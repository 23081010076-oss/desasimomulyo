Act as a Senior Principal Full-Stack Engineer. I am building a "Sistem Informasi Desa & Layanan Hotline Terpadu" (Village Information System & Integrated Hotline). 

You must structure the Laravel backend using the Service-Repository Pattern to keep the controllers thin and maintain a clean architecture approach.

TECH STACK:
- Backend: Laravel 11 (PHP 8.x)
- Database: MySQL / PostgreSQL
- Queue: Redis (for asynchronous notifications)
- Client (Citizen App/Hotline): React Native
- Web (Admin Dashboard): Laravel Blade / Inertia.js (React)

SYSTEM MODULES & BUSINESS RULES:

1. E-Lapor & Hotline Module (Core)
   - Models: Report, User, ReportCategory.
   - Statuses: PENDING, PROCESSED, RESOLVED, REJECTED.
   - Rules: Citizens must provide GPS coordinates (latitude/longitude) and attach at least one image path for standard reports.
   - Panic Button Feature: Triggers an immediate "EMERGENCY" status report with real-time location. Bypasses standard validation for speed.
   - Notification Interface: Requires a WhatsApp Gateway integration. Must use Laravel Jobs/Queues to send notifications asynchronously (to Admin on creation, to Citizen on status update) without blocking the API response.

2. E-Government (Surat) Module
   - Models: DocumentRequest, DocumentType.
   - Statuses: DRAFT, VERIFYING, SIGNED, COMPLETED.
   - Rules: Tracks approval workflow, linking request to Citizen (User) and Admin.

3. Transparency & Information Module
   - Models: Article (News), BudgetTransaction (APBDes), Product (UMKM).

YOUR TASKS (GENERATE IN THIS EXACT ORDER):

TASK 1: DIRECTORY STRUCTURE
Provide the folder structure mapping for this Laravel project, focusing on where the custom logic goes. Explicitly show:
- app/Http/Controllers/Api
- app/Http/Requests (Form Validation)
- app/Http/Resources (API Response Formatting)
- app/Services (Business Logic)
- app/Repositories (Data Access Layer)
- app/Jobs (Asynchronous tasks)

TASK 2: MIGRATIONS & ELOQUENT MODELS
Write the Laravel Migration and Eloquent Model code for the `reports` table.
- Include spatial data types or decimal columns for coordinates.
- Define the ENUM statuses.
- Write the `Report` Model showing proper relationships (belongsTo User) and `$casts`.

TASK 3: SERVICE IMPLEMENTATION (PANIC BUTTON)
Write the exact PHP code for `app/Services/ReportService.php` focusing on the `triggerPanicButton` method.
- Show Dependency Injection of a `ReportRepositoryInterface`.
- Show how the database transaction (DB::transaction) is handled.
- Show how the `SendEmergencyWhatsAppJob` is dispatched to the queue.

TASK 4: API ROUTES & CONTROLLER
Provide the `routes/api.php` definitions and the `ReportController` for:
- POST `/api/v1/reports` (Standard report)
- POST `/api/v1/hotline/panic` (Panic Button)
Show how the Controller calls the Service and returns an API Resource.

TASK 5: REACT NATIVE IMPLEMENTATION
Provide the React Native boilerplate (using functional components and custom hooks) for the "Panic Button" screen. Show how it captures device geolocation (using expo-location or react-native-geolocation-service) and sends the POST request to the Laravel backend using Axios.