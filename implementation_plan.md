# Implementation Plan — todo2.txt Full Requirements

This plan covers all 10 feature epics from [todo2.txt](file:///c:/laragon/www/justproperties/todo2.txt) in the recommended execution order (database-first, then backend, then views).

---

## Epic 1 — Manual Payment

**Goal**: Allow admin to record bank details per country and allow users to pay manually with receipt upload.

### Database
#### ~~[NEW] `add_bank_details_to_countries_table.php`~~ *(reverted — no-op)*
> [!IMPORTANT]
> **Decision (Q4 revised)**: Bank details are stored **per currency** (not per country), since a currency is tied to the payment method. Two countries can share the same currency and same bank account.

#### [NEW] `add_bank_details_to_currencies_table.php`
- Add `bank_details` (JSON, nullable) to `currencies` table

#### [NEW] `add_receipt_to_payments_table.php`
- Add `receipt` (string, nullable) to `payments` table

### Models
#### ~~[MODIFY] Country.php~~ *(not needed for bank_details)*

#### [MODIFY] [Currency.php](file:///c:/laragon/www/justproperties/app/Models/Currency.php)
- Add `bank_details` to `#[Fillable]`
- Add `'bank_details' => 'array'` cast

#### [MODIFY] [Payment.php](file:///c:/laragon/www/justproperties/app/Models/Payment.php)
- Add `receipt` to `#[Fillable]`

### Admin — AdminCurrencies Settings
#### [MODIFY] `app/Livewire/Admin/Settings/AdminCurrencies.php`
- Add public fields: `$show_manual_payment`, `$bank_name`, `$bank_account_number`, `$account_name`, `$swift_code`
- Populate in `openEdit()`, save in `saveCurrency()`

#### [MODIFY] `resources/views/livewire/admin/settings/admin-currencies.blade.php`
- Add bank details fields (toggle + inputs) in the create/edit modal

### Checkout — Manual Payment Option
#### [MODIFY] [Checkout.php](file:///c:/laragon/www/justproperties/app/Livewire/Seller/Checkout.php)
- Add `WithFileUploads` trait
- Add `$paymentMethod = 'gateway'`, `$receiptFile` properties
- Add `submitManualPayment()` method: validate + store receipt + set payment `status = 'pending'`, `method = 'manual'`

#### [MODIFY] `resources/views/livewire/seller/checkout.blade.php`
- If country has bank_details: show "Manual Payment" option with bank details
- Show file upload for receipt; hide on gateway selection

### Admin — AdminPayments Receipt Review
#### [MODIFY] [AdminPayments.php](file:///c:/laragon/www/justproperties/app/Livewire/Admin/AdminPayments.php)
- Add `confirmPayment(int $id)` method: set payment status to `'success'`, set `paid_at = now()`

#### [MODIFY] `resources/views/livewire/admin/admin-payments.blade.php`
- Show receipt download link if `method = 'manual'` and `status = 'pending'`
- Show "Confirm Payment" button

---

## Epic 2 — Orientation Page (Role Welcome) Redesign

**Goal**: Expand the 2-panel welcome screen to 6 intent-based tiles.

#### [MODIFY] [role-welcome.blade.php](file:///c:/laragon/www/justproperties/resources/views/livewire/auth/role-welcome.blade.php)
Replace the 2-column buyer/seller panels with 6 cards:
1. **Rent** → buyer dashboard
2. **Shortlet** → buyer dashboard
3. **Buy** → buyer dashboard
4. **Sell** → seller dashboard
5. **Seller Dashboard** → seller dashboard
6. **Buyer Dashboard** → buyer dashboard

#### [MODIFY] [RoleWelcome.php](file:///c:/laragon/www/justproperties/app/Livewire/Auth/RoleWelcome.php)
- Add `chooseRole(string $role)` method to set `active_role` then redirect

---

## Epic 3 — FAQ System

**Goal**: Admin-managed FAQ, widget on app layout, FAQ section on Contact page.

### Database
#### [NEW] `create_faqs_table.php`
- Fields: `id`, `question`, `answer`, `is_active` (boolean), `show_on_contact_page` (boolean), `created_at`, `updated_at`

### Model
#### [NEW] `app/Models/Faq.php`
- Fillable: `question`, `answer`, `is_active`, `show_on_contact_page`

### Admin CRUD
#### [NEW] `app/Livewire/Admin/AdminFaqs.php`
- Create, edit, toggle active, delete FAQs

#### [NEW] `resources/views/livewire/admin/admin-faqs.blade.php`

#### [MODIFY] [web.php](file:///c:/laragon/www/justproperties/routes/web.php)
- Add admin route: `admin/faqs`

#### [MODIFY] Admin sidebar nav
- Add FAQ menu item

### Contact Page (dynamic FAQs)
#### [MODIFY] [Contact.php](file:///c:/laragon/www/justproperties/app/Livewire/Guest/Contact.php)
- Pass `Faq::where('show_on_contact_page', true)->where('is_active', true)->get()` to view

#### [MODIFY] [contact.blade.php](file:///c:/laragon/www/justproperties/resources/views/livewire/guest/contact.blade.php)
- Replace hardcoded FAQ cards with dynamic loop

### App Layout Chat Widget
#### [MODIFY] [app.blade.php](file:///c:/laragon/www/justproperties/resources/views/layouts/app.blade.php)
- Convert bottom-right button into a FAQ chat popover panel
- Load active FAQs as clickable questions; clicking a question shows the answer
- Add "Back" button to return to question list

---

## Epic 4 — Contact Us Improvements

**Goal**: Functional Livewire contact form with email, feedback/adverts subjects.

#### [NEW] `app/Mail/ContactMessage.php`
- Mailable for contact form submissions

#### [MODIFY] [Contact.php](file:///c:/laragon/www/justproperties/app/Livewire/Guest/Contact.php)
- Add public props: `$name`, `$email`, `$phone`, `$subject`, `$message`
- Add `send()` method: validate → send mail to `env('MAIL_FROM_ADDRESS')` → flash success/error

#### [MODIFY] [contact.blade.php](file:///c:/laragon/www/justproperties/resources/views/livewire/guest/contact.blade.php)
- Convert plain HTML `<form>` to `wire:submit.prevent="send"`, `wire:model` bindings
- Add subject options: **Feedback** and **Adverts**
- Display flash session success/error message

---

## Epic 5 — Pricing Page Livewire Conversion

**Goal**: Convert static pricing view to Livewire component with real data.

#### [NEW] `app/Livewire/Guest/Pricing.php`
- `mount()`: set `$selectedCountryId` to user's country or default
- `updatedSelectedCountryId()` to reload plans
- Pass `SubscriptionPlan` data to view

#### [MODIFY] [web.php](file:///c:/laragon/www/justproperties/routes/web.php)
- Replace `Route::view(...)` → `Route::get('pricing', Pricing::class)->name('pricing')`

#### [MODIFY] [pricing.blade.php](file:///c:/laragon/www/justproperties/resources/views/livewire/guest/pricing.blade.php)
- Remove standalone HTML shell
- Wrap in Livewire component with `layouts.app`
- Add country switcher dropdown (wire:model)
- Render plans dynamically from passed data

---

## Epic 6 — Seeders

**Goal**: Rich data: 10 users, 20 blog posts, 50 properties (all types).

#### [NEW] `database/seeders/UsersSeeder.php`
- 10 users (varied roles, countries)

#### [NEW] `database/seeders/BlogPostsSeeder.php`
- 20 blog posts across categories (uses Factory or inline)

#### [NEW] `database/seeders/PropertiesSeeder.php`
- 50 properties across all category types

#### [MODIFY] [PropertyObserver.php](file:///c:/laragon/www/justproperties/app/Observers/PropertyObserver.php)
- Add seeder-aware check: when seeding, create moderation record with `status = 'approved'` instead of `'pending'`

#### [MODIFY] [DatabaseSeeder.php](file:///c:/laragon/www/justproperties/database/seeders/DatabaseSeeder.php)
- Add new seeders to call chain

---

## Epic 7 — Blog Post Tags (comma-separated display)

**Goal**: Display tags as comma-separated clickable strings in post list and blog views.

#### [MODIFY] [AdminBlogPostEdit.php](file:///c:/laragon/www/justproperties/app/Livewire/Admin/AdminBlogPostEdit.php)
- On `mount()`, convert stored tags array → comma-separated string for `$tagsInput`

#### [MODIFY] Admin blog post list blade
- Display tags as comma-separated linked strings

#### [MODIFY] [BlogRoll.php](file:///c:/laragon/www/justproperties/app/Livewire/Guest/BlogRoll.php)
- Add `$tag = ''` URL parameter with `#[Url]`
- Filter posts by tag: `whereJsonContains('tags', $this->tag)`

#### [MODIFY] [BlogPost.php](file:///c:/laragon/www/justproperties/app/Livewire/Guest/BlogPost.php)
- Pass post tags to view as linked chips

#### [MODIFY] blog-roll + blog-post blades
- Show tags as clickable links `?tag=xyz`

---

## Epic 8 — Categories Improvements

**Goal**: `is_property` column, Facilities category, blog-only categories, filtering fixes.

### Database
#### [NEW] `add_is_property_to_categories_table.php`
- Add `is_property` boolean (default `true`) to `categories` table

### Model
#### [MODIFY] [Category.php](file:///c:/laragon/www/justproperties/app/Models/Category.php)
- Add `is_property` to `#[Fillable]` and cast

### Seeder
#### [MODIFY] [CategoriesSeeder.php](file:///c:/laragon/www/justproperties/database/seeders/CategoriesSeeder.php)
- Mark all existing property categories with `is_property = true`
- Add **Facilities** category with types (factory, warehouse, industrial, hotel, hospital, school, etc.)
- Add non-property blog categories with `is_property = false` via `updateOrCreate`

### Admin
#### [MODIFY] [AdminCategories.php](file:///c:/laragon/www/justproperties/app/Livewire/Admin/Settings/AdminCategories.php)
- Filter to `where('is_property', true)` in `mount()` and `render()`
- Remove category creation UI

### Blog Post Create/Edit
#### [MODIFY] [AdminBlogPostCreate.php](file:///c:/laragon/www/justproperties/app/Livewire/Admin/AdminBlogPostCreate.php) + Edit
- Load **all** categories (no `is_property` filter)

### Welcome Page
#### [MODIFY] [Welcome.php](file:///c:/laragon/www/justproperties/app/Livewire/Guest/Welcome.php)
- Add `Category::where('is_property', true)->get()` to render data

### Footer
#### [MODIFY] [Footer.php](file:///c:/laragon/www/justproperties/app/Livewire/Guest/Footer.php)
- Load `Category::where('is_property', false)->get()` → pass to view

#### [MODIFY] [footer.blade.php](file:///c:/laragon/www/justproperties/resources/views/livewire/guest/footer.blade.php)
- Under Resources, list non-property categories as blog links

---

## Epic 9 — Advertisement Page + Admin Table

**Goal**: Marketing "Advertise" page, ads DB table, admin management.

### Database
#### [NEW] `create_advertisements_table.php`
- Fields: `id`, `image`, `description`, `placement`, `company`, `amount`, `payment_method`, `payment_status`, `receipt`, `start_date`, `end_date`, `created_at`, `updated_at`

### Model
#### [NEW] `app/Models/Advertisement.php`

### Public Page
#### [NEW] `app/Livewire/Guest/Advertise.php`
#### [NEW] `resources/views/livewire/guest/advertise.blade.php`
- Marketing page: benefits, who can benefit list, ad placements/types, CTA button to Contact

#### [MODIFY] [web.php](file:///c:/laragon/www/justproperties/routes/web.php)
- Add: `Route::get('advertise', Advertise::class)->name('advertise')`

#### [MODIFY] [footer.blade.php](file:///c:/laragon/www/justproperties/resources/views/livewire/guest/footer.blade.php)
- Update "Advertize" link to `route('advertise')`

### Admin
#### [NEW] `app/Livewire/Admin/AdminAdvertisements.php`
- List, view details, update status for advertisements

#### [NEW] `resources/views/livewire/admin/admin-advertisements.blade.php`

#### [MODIFY] [web.php](file:///c:/laragon/www/justproperties/routes/web.php)
- Add admin route: `admin/advertisements`

#### [MODIFY] Admin sidebar
- Add "Advertisements" menu item

---

## Epic 10 — Country/State/City API Auto-Population

**Goal**: On registration, auto-fetch states + cities from CountryStateCity API.

#### [NEW] `app/Services/GeographyService.php`
- `fetchAndSaveStates(Country $country): void` — check DB first, then call API
- `fetchAndSaveCities(Country $country): void` — check DB first, then call API

#### [NEW] `app/Jobs/PopulateCountryGeography.php`
- Queued job calling both GeographyService methods

#### [NEW] `app/Listeners/PopulateGeographyForNewUser.php`
- Listens on `Illuminate\Auth\Events\Registered`
- Dispatches `PopulateCountryGeography` job

#### [MODIFY] `app/Providers/EventServiceProvider.php`
- Register listener: `Registered` → `PopulateGeographyForNewUser`

#### [MODIFY] [State.php](file:///c:/laragon/www/justproperties/app/Models/State.php) + [City.php](file:///c:/laragon/www/justproperties/app/Models/City.php)
- Add `latitude`, `longitude`, `timezone` to fillable (and `population` for cities)

---

## Execution Order (Recommended)

| Step | What | Why |
|------|------|-----|
| 1 | All DB migrations | Must run before any code references new columns |
| 2 | All Model updates | Models needed by components |
| 3 | CategoriesSeeder update | Enables `is_property` flag |
| 4 | Epic 3: FAQ system | Self-contained |
| 5 | Epic 4: Contact improvements | Uses FAQ component data |
| 6 | Epic 8: Categories improvements | Fixes Welcome, Footer, BlogPost admin |
| 7 | Epic 7: Blog tags | Depends on categories being correct |
| 8 | Epic 5: Pricing Livewire | Standalone conversion |
| 9 | Epic 2: Role Welcome | Pure view redesign |
| 10 | Epic 1: Manual Payment | Needs bank_details migration done |
| 11 | Epic 9: Advertisement | Self-contained |
| 12 | Epic 6: Seeders | Needs all models/categories ready |
| 13 | Epic 10: Geography API | Needs queue config + State/City models |

---

## Open Questions

> [!IMPORTANT]
> **Q1 — FAQ Widget**: Should the FAQ chat widget **replace** the existing bottom-right support button entirely, or be a separate panel that opens alongside it?

> [!IMPORTANT]
> **Q2 — Pricing Page Layout**: The current pricing page is a full standalone HTML document. Should it be converted to use `layouts.app` (navbar + footer), or kept as a standalone page?

> [!IMPORTANT]
> **Q3 — Geography API Sync**: Calling the API synchronously at registration could slow it down. Should we use a **queued job** (requires queue worker), or fire-and-forget with `dispatch()->afterResponse()`?

> [!WARNING]
> **Q4 — Manual Payment Bank Details Source**: Bank details should come from the **user's registered country**. Is this correct, or should it be the payment currency's country?

> [!NOTE]
> **Q5 — Seeders Idempotency**: Should all new seeders use `updateOrCreate` to be safe on existing databases, or is a fresh wipe assumed?
