<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Category;
use App\Models\CategorySetting;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AdminCategories extends Component
{
    public ?int $selectedCategoryId = null;

    public string $categoryName = '';

    public string $categorySlug = '';

    public bool $showEditModal = false;

    public ?int $editingSettingId = null;

    public string $editKey = '';

    public string $editLabel = '';

    public string $editDataType = CategorySetting::TYPE_TEXT;

    public bool $editRequired = false;

    public string $editOptionsLines = '';

    public int $editSort = 0;

    public string $editValidationJson = '';

    public bool $showAddModal = false;

    public string $newKey = '';

    public string $newLabel = '';

    public string $newDataType = CategorySetting::TYPE_TEXT;

    public bool $newRequired = false;

    public string $newOptionsLines = '';

    public int $newSortOrder = 0;

    public function mount(): void
    {
        $this->selectedCategoryId = Category::query()->orderBy('name')->value('id');
        $this->loadCategoryMeta();
    }

    public function updatedSelectedCategoryId(): void
    {
        $this->closeEditModal();
        $this->closeAddModal();
        $this->loadCategoryMeta();
    }

    public function loadCategoryMeta(): void
    {
        $this->categoryName = '';
        $this->categorySlug = '';

        if (! $this->selectedCategoryId) {
            return;
        }

        $category = Category::query()->find($this->selectedCategoryId);
        if (! $category) {
            return;
        }

        $this->categoryName = $category->name;
        $this->categorySlug = (string) ($category->slug ?? '');
    }

    public function saveCategoryMeta(): void
    {
        $this->validate([
            'selectedCategoryId' => ['required', 'integer', 'exists:categories,id'],
            'categoryName' => ['required', 'string', 'max:255'],
        ]);

        $category = Category::query()->findOrFail($this->selectedCategoryId);
        $category->update(['name' => $this->categoryName]);

        session()->flash('status', 'Category name saved.');
    }

    public function openEditModal(int $settingId): void
    {
        $setting = CategorySetting::query()
            ->where('category_id', $this->selectedCategoryId)
            ->whereKey($settingId)
            ->firstOrFail();

        $this->editingSettingId = $setting->id;
        $this->editKey = $setting->key;
        $this->editLabel = $setting->label;
        $this->editDataType = $setting->data_type;
        $this->editRequired = $setting->is_required;
        $this->editOptionsLines = implode("\n", $setting->options ?? []);
        $this->editSort = (int) $setting->sort_order;
        $this->editValidationJson = $setting->validation !== null
            ? json_encode($setting->validation, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            : '';
        $this->resetErrorBag();
        $this->showEditModal = true;
    }

    public function closeEditModal(): void
    {
        $this->showEditModal = false;
        $this->editingSettingId = null;
        $this->reset([
            'editKey',
            'editLabel',
            'editDataType',
            'editRequired',
            'editOptionsLines',
            'editSort',
            'editValidationJson',
        ]);
        $this->editDataType = CategorySetting::TYPE_TEXT;
    }

    public function saveEditModal(): void
    {
        $this->validate([
            'editingSettingId' => ['required', 'integer'],
            'editLabel' => ['required', 'string', 'max:255'],
            'editDataType' => ['required', Rule::in($this->dataTypeOptions())],
            'editSort' => ['required', 'integer', 'min:0', 'max:999999'],
            'editValidationJson' => ['nullable', 'string'],
        ]);

        $setting = CategorySetting::query()
            ->where('category_id', $this->selectedCategoryId)
            ->whereKey($this->editingSettingId)
            ->firstOrFail();

        $options = $this->parseOptionsLines($this->editOptionsLines);

        $validationRaw = trim($this->editValidationJson);
        $validation = null;
        if ($validationRaw !== '') {
            $decoded = json_decode($validationRaw, true);
            if (json_last_error() !== JSON_ERROR_NONE || ! is_array($decoded)) {
                $this->addError('editValidationJson', 'Must be valid JSON (object or array).');

                return;
            }
            $validation = $decoded;
        }

        $setting->update([
            'label' => $this->editLabel,
            'data_type' => $this->editDataType,
            'is_required' => $this->editRequired,
            'options' => $options,
            'validation' => $validation,
            'sort_order' => $this->editSort,
        ]);

        $key = $setting->key;
        $this->closeEditModal();

        session()->flash('status', "Setting “{$key}” saved.");
    }

    public function openAddModal(): void
    {
        $this->reset(['newKey', 'newLabel', 'newOptionsLines']);
        $this->newDataType = CategorySetting::TYPE_TEXT;
        $this->newRequired = false;
        $this->newSortOrder = 0;
        $this->resetErrorBag();
        $this->showAddModal = true;
    }

    public function closeAddModal(): void
    {
        $this->showAddModal = false;
        $this->reset(['newKey', 'newLabel', 'newOptionsLines']);
        $this->newDataType = CategorySetting::TYPE_TEXT;
        $this->newRequired = false;
        $this->newSortOrder = 0;
    }

    public function addSetting(): void
    {
        $this->validate([
            'selectedCategoryId' => ['required', 'integer', 'exists:categories,id'],
            'newKey' => [
                'required',
                'string',
                'max:120',
                'regex:/^[a-z][a-z0-9_]*$/',
                Rule::unique('category_settings', 'key')->where(
                    fn ($query) => $query->where('category_id', $this->selectedCategoryId)
                ),
            ],
            'newLabel' => ['required', 'string', 'max:255'],
            'newDataType' => ['required', Rule::in($this->dataTypeOptions())],
            'newSortOrder' => ['required', 'integer', 'min:0', 'max:999999'],
        ]);

        $options = $this->parseOptionsLines($this->newOptionsLines);

        CategorySetting::query()->create([
            'category_id' => $this->selectedCategoryId,
            'key' => $this->newKey,
            'label' => $this->newLabel,
            'data_type' => $this->newDataType,
            'is_required' => $this->newRequired,
            'options' => $options,
            'default_value' => null,
            'validation' => null,
            'sort_order' => $this->newSortOrder,
        ]);

        $this->closeAddModal();

        session()->flash('status', 'New field added.');
    }

    public function deleteSetting(int $settingId): void
    {
        $setting = CategorySetting::query()
            ->where('category_id', $this->selectedCategoryId)
            ->whereKey($settingId)
            ->firstOrFail();

        $key = $setting->key;
        $setting->delete();

        if ($this->editingSettingId === $settingId) {
            $this->closeEditModal();
        }

        session()->flash('status', "Field “{$key}” removed.");
    }

    /**
     * @return list<string>
     */
    public function dataTypeOptions(): array
    {
        return [
            CategorySetting::TYPE_ENUM,
            CategorySetting::TYPE_MULTI_ENUM,
            CategorySetting::TYPE_NUMBER,
            CategorySetting::TYPE_TEXT,
            CategorySetting::TYPE_TEXTAREA,
            CategorySetting::TYPE_BOOLEAN,
            CategorySetting::TYPE_DATE,
        ];
    }

    protected function parseOptionsLines(string $raw): ?array
    {
        $lines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $raw) ?: [])));

        return $lines === [] ? null : $lines;
    }

    public function render(): View
    {
        $categories = Category::query()
            ->withCount('settings')
            ->orderBy('name')
            ->get();

        $selectedCategory = $this->selectedCategoryId
            ? Category::query()->with(['settings' => fn ($q) => $q->orderBy('sort_order')])->find($this->selectedCategoryId)
            : null;

        return view('livewire.admin.admin-settings.categories', [
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'dataTypeOptions' => $this->dataTypeOptions(),
        ]);
    }
}
