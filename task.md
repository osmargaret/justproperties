## PHASE 1 — All Migrations
- [ ] add_bank_details_to_countries_table
- [ ] add_receipt_to_payments_table
- [ ] create_faqs_table
- [ ] add_is_property_to_categories_table
- [ ] create_advertisements_table

## PHASE 2 — All Models
- [ ] Country.php — add bank_details fillable + cast
- [ ] Payment.php — add receipt fillable
- [ ] Faq.php — NEW model
- [ ] Category.php — add is_property fillable + cast
- [ ] Advertisement.php — NEW model
- [ ] State.php — add lat/lng/timezone fillable
- [ ] City.php — add lat/lng/timezone/population fillable

## PHASE 3 — CategoriesSeeder update
- [ ] Mark existing categories with is_property=true
- [ ] Add Facilities category (factory, warehouse, industrial, hotel, hospital, school, etc.)
- [ ] Add non-property blog categories (Mortgage, Tax, Property Management, Investment, Legal)

## PHASE 4 — Epic 3: FAQ System
- [ ] AdminFaqs.php — Livewire component (CRUD)
- [ ] admin-faqs.blade.php — Admin view
- [ ] Route for admin/faqs
- [ ] Admin sidebar — Add FAQ menu item
- [ ] Contact.php — pass dynamic FAQs to view
- [ ] contact.blade.php — render dynamic FAQs
- [ ] app.blade.php — convert support button to FAQ chat widget

## PHASE 5 — Epic 4: Contact Improvements
- [ ] ContactMessage.php — Mailable
- [ ] Contact.php — add form fields, send() method
- [ ] contact.blade.php — wire:model bindings, add Feedback + Adverts subjects, success/error flash

## PHASE 6 — Epic 8: Categories Improvements
- [ ] AdminCategories.php — filter to is_property=true only, remove creation UI
- [ ] AdminBlogPostCreate.php + Edit — show ALL categories
- [ ] Welcome.php — filter categories where is_property=true
- [ ] Footer.php — load non-property categories
- [ ] footer.blade.php — list non-property category links under Resources

## PHASE 7 — Epic 7: Blog Tags
- [ ] AdminBlogPostEdit.php — convert stored array to comma-string in tagsInput
- [ ] Admin blog list blade — show tags as comma-separated links
- [ ] BlogRoll.php — add $tag URL param + whereJsonContains filter
- [ ] BlogPost.php — pass tags to view
- [ ] blog-roll.blade.php + blog-post.blade.php — clickable tag links

## PHASE 8 — Epic 5: Pricing Page Livewire
- [ ] Pricing.php — NEW Livewire component
- [ ] web.php — replace Route::view with Route::get(Pricing::class)
- [ ] pricing.blade.php — convert to Livewire view using layouts.app

## PHASE 9 — Epic 2: Role Welcome Redesign
- [ ] role-welcome.blade.php — 6-card layout (Rent, Shortlet, Buy, Sell, Seller Dashboard, Buyer Dashboard)
- [ ] RoleWelcome.php — add chooseRole() method

## PHASE 10 — Epic 1: Manual Payment
- [ ] AdminCountries.php — bank details fields in create/edit
- [ ] admin-countries.blade.php — bank detail form fields
- [ ] Checkout.php — manual payment method + receipt upload
- [ ] checkout.blade.php — show bank details + receipt upload UI
- [ ] AdminPayments.php — confirmPayment() method
- [ ] admin-payments.blade.php — receipt view + confirm button

## PHASE 11 — Epic 9: Advertisement
- [ ] Advertise.php — NEW Livewire component (marketing page)
- [ ] advertise.blade.php — marketing view
- [ ] Route for /advertise
- [ ] footer.blade.php — link Advertize to route('advertise')
- [ ] AdminAdvertisements.php — NEW admin component
- [ ] admin-advertisements.blade.php — admin view
- [ ] Admin route + sidebar item

## PHASE 12 — Epic 6: Seeders
- [ ] UsersSeeder.php — 10 users
- [ ] BlogPostsSeeder.php — 20 blog posts
- [ ] PropertiesSeeder.php — 50 properties
- [ ] PropertyObserver.php — seeder-aware approved status
- [ ] DatabaseSeeder.php — add new seeders

## PHASE 13 — Epic 10: Geography API
- [ ] GeographyService.php — NEW service (fetch+save states & cities)
- [ ] Register.php — call GeographyService after user creation (afterResponse dispatch)
- [ ] State.php + City.php — add lat/lng fillable fields (already done in Phase 2)
