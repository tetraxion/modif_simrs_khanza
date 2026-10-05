# Implementation Plan: SIMRS Khanza Full System Refactoring

## Overview

This implementation plan breaks down the complete refactoring of the Laravel-based Hospital Information Management System into discrete, manageable tasks. The system will support comprehensive hospital operations including patient registration, clinical documentation, pharmacy, laboratory, radiology, billing, and external integrations with BPJS and SATUSEHAT platforms.

**Implementation Language:** PHP 8.3+ with Laravel 11

**Estimated Total Duration:** 16-20 weeks

**Key Dependencies:**
- Laravel 11 framework
- MySQL 8.0+ database
- Redis 7.0+ for caching and queues
- PHP 8.3+ runtime
- Composer for dependency management

---

## Tasks

### Phase 1: Foundation (Infrastructure & Core)

- [x] 1. Environment Setup and Project Configuration
  - Install Laravel 11 with PHP 8.3+
  - Configure MySQL 8.0+ database connection
  - Configure Redis for caching and queue
  - Set up S3/MinIO for file storage
  - Install required Composer packages (Livewire 3, Alpine.js, Tailwind CSS)
  - Configure Laravel Telescope for development monitoring
  - Configure Sentry for production error tracking
  - **Files to create:** `.env.example`, `config/bpjs.php`, `config/satusehat.php`, `config/filesystems.php` (extend)
  - **Estimated time:** 1 day
  - **Status:** ✅ COMPLETED - All packages installed (Livewire 4.4.5, Telescope 5.24.0, Sentry 4.27.0), configuration files created
  - _Requirements: System requirements (Req 35)_

- [x] 2. Create Database Schema - Core Extensions
  - Extend `rawat_jalans` table with SOAP fields and indices
  - Extend `beds` table with bed type and equipment fields
  - Extend `obats` table with BPJS formulary and high-alert flags
  - Extend `billings` table with insurance class and status fields
  - Add UUID columns to major tables
  - **Files to create:** `database/migrations/2024_xx_xx_extend_existing_tables.php`
  - **Estimated time:** 2 days
  - _Requirements: Multiple requirements needing schema updates_

- [x] 3. Create Database Schema - New Tables (Part 1: Clinical)
  - Create `vital_signs` table with patient and visit polymorphic relationships
  - Create `diagnoses` table with ICD-10 codes and polymorphic visit relationship
  - Create `procedures` table with ICD-9-CM codes
  - Create `cppt_entries` table for integrated progress notes
  - Create `nursing_assessments` table with risk scoring
  - Create `fluid_balance_records` table with calculated balance
  - **Files to create:** `database/migrations/2024_xx_xx_create_clinical_tables.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 4, 5, 15, 16, 17_

- [-] 4. Create Database Schema - New Tables (Part 2: Laboratory)
  - Create `lab_orders` table with order tracking
  - Create `lab_order_items` table for individual tests
  - Create `lab_results` table with normal range flagging
  - Create `lab_test_catalog` table with test definitions
  - Create `lab_test_templates` and `lab_test_template_items` tables
  - **Files to create:** `database/migrations/2024_xx_xx_create_laboratory_tables.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 6, 7, 8_

- [ ] 5. Create Database Schema - New Tables (Part 3: Pharmacy)
  - Create `drug_batches` table for FIFO stock management
  - Create `drug_interactions` table with severity levels
  - Create `prescription_verifications` table with pharmacist sign-off
  - Create `drug_stock_movements` table for inventory tracking
  - Create `drug_formulary` table for BPJS coverage status
  - **Files to create:** `database/migrations/2024_xx_xx_create_pharmacy_tables.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 11, 12, 13, 38_

- [ ] 6. Create Database Schema - New Tables (Part 4: Supporting)
  - Create `invoice_items` table for itemized billing
  - Create `payments` table with multi-method support
  - Create `tariffs` table with insurance class pricing
  - Create `bed_transfers` table for bed movement tracking
  - Create `discharge_summaries` table
  - Create `active_problems` and `allergies` tables
  - Create `uploaded_documents` table for scanned files
  - Create `medical_record_access_logs` table for audit trail
  - **Files to create:** `database/migrations/2024_xx_xx_create_supporting_tables.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 23, 24, 25, 26, 32_

- [ ] 7. Create Database Schema - New Tables (Part 5: BPJS & SATUSEHAT)
  - Create `bpjs_cards` table for BPJS member information
  - Create `seps` table for eligibility letters
  - Create `bpjs_claims` table for claim submissions
  - Create `bpjs_claim_verifications` table
  - Create `satusehat_submissions` table for FHIR data sync
  - Create `satusehat_errors` table for error tracking
  - **Files to create:** `database/migrations/2024_xx_xx_create_integration_tables.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 3, 28, 29_

- [ ] 8. Create Database Schema - Indices and Constraints
  - Add performance indices to all tables
  - Add foreign key constraints with cascading rules
  - Add full-text search indices for patient and drug search
  - Add composite indices for common query patterns
  - **Files to create:** `database/migrations/2024_xx_xx_add_indices_and_constraints.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 35 (Performance optimization)_

- [ ] 9. Checkpoint - Verify Database Schema
  - Run all migrations on fresh database
  - Verify all tables created successfully
  - Test rollback functionality
  - Document schema in ER diagram
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 10. Implement Authentication and Authorization System
  - Create `Role` and `Permission` models with Spatie Laravel Permission
  - Define roles: Admin, Doctor, Nurse, Pharmacist, Lab Technician, Radiographer, Registration Staff, Billing Staff
  - Create role seeder with permissions
  - Implement middleware for role-based access
  - Create user management interface
  - **Files to create:** `app/Models/Role.php`, `app/Models/Permission.php`, `database/seeders/RolePermissionSeeder.php`, `app/Http/Middleware/CheckRole.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 33 (System configuration)_

- [ ] 11. Implement Audit Trail System
  - Create `AuditLog` model for activity logging
  - Create `Auditable` trait for automatic audit logging
  - Implement audit log middleware for HTTP requests
  - Create audit log observer for model events
  - Create audit log search and viewing interface
  - **Files to create:** `app/Models/AuditLog.php`, `app/Traits/Auditable.php`, `app/Observers/AuditObserver.php`, `app/Http/Middleware/AuditMiddleware.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 32_

- [ ] 12. Create Core Service Classes and Repositories
  - Create `BaseService` abstract class with common methods
  - Create `BaseRepository` abstract class with query patterns
  - Create `HasUuid` trait for UUID generation
  - Create `Searchable` trait for search functionality
  - Create global helper functions file
  - **Files to create:** `app/Services/BaseService.php`, `app/Repositories/BaseRepository.php`, `app/Traits/HasUuid.php`, `app/Traits/Searchable.php`, `app/Helpers/helpers.php`
  - **Estimated time:** 1 day
  - _Requirements: Supporting infrastructure_

- [ ] 13. Implement Notification System
  - Create notification channels (database, email, SMS, in-app)
  - Create `CriticalValueNotification` class
  - Create `StatOrderNotification` class
  - Create `MedicationReminderNotification` class
  - Create notification preference system
  - Implement notification escalation for unacknowledged critical alerts
  - **Files to create:** `app/Notifications/CriticalValueNotification.php`, `app/Notifications/StatOrderNotification.php`, `app/Notifications/MedicationReminderNotification.php`, `app/Services/NotificationService.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 36_

- [ ] 14. Configure Redis Caching Strategy
  - Configure Redis cache driver with tags support
  - Create cache service for reference data (ICD codes, tariffs)
  - Implement cache invalidation strategy
  - Configure session storage in Redis
  - Set up cache warming for frequently accessed data
  - **Files to modify:** `config/cache.php`, `config/session.php`
  - **Files to create:** `app/Services/CacheService.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 35 (Performance optimization)_

- [ ] 15. Set Up Queue System
  - Configure Redis queue connection
  - Create separate queues by priority (critical, high, default, low)
  - Create failed job monitoring
  - Set up Horizon for queue monitoring (optional)
  - Create queue worker supervisor configuration
  - **Files to modify:** `config/queue.php`
  - **Files to create:** `config/horizon.php` (if using Horizon)
  - **Estimated time:** 1 day
  - _Requirements: Background processing for integrations_

### Phase 2: Patient Management

- [ ] 16. Implement Patient Model and Repository
  - Create `Patient` model extending existing model
  - Add `HasUuid` and `Auditable` traits
  - Define relationships (visits, prescriptions, lab orders, allergies)
  - Create age and age group accessors
  - Create patient search scope
  - Create `PatientRepository` with search methods
  - **Files to create:** `app/Models/Patient.php`, `app/Repositories/PatientRepository.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 1, 26_

- [ ] 17. Implement Medical Record Number Generation Service
  - Create `MedicalRecordNumberService` class
  - Implement sequential MR number generation with format validation
  - Add transaction locking to prevent duplicate numbers
  - Create MR number counter table and model
  - Add configuration for MR number format
  - **Files to create:** `app/Services/MedicalRecordNumberService.php`, `database/migrations/2024_xx_xx_create_mr_counters_table.php`, `app/Models/MrCounter.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 1_

- [ ]* 17.1. Write property test for MR number generation round-trip
  - **Property 1: MR Number Round Trip**
  - **Validates: Requirements 1.7**
  - Use Eris/Pest to generate random patient data
  - Test that generating MR number → saving → retrieving returns same MR number
  - Test for 100+ random patient registrations
  - **Files to create:** `tests/PropertyBased/MedicalRecordNumberPropertyTest.php`
  - **Estimated time:** 0.5 days

- [ ] 18. Implement Duplicate Patient Detection Service
  - Create `DuplicatePatientCheckService` class
  - Implement NIK duplicate check
  - Implement BPJS number duplicate check
  - Create `DuplicatePatientException` custom exception
  - Add fuzzy matching for similar names (optional enhancement)
  - **Files to create:** `app/Services/DuplicatePatientCheckService.php`, `app/Exceptions/DuplicatePatientException.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 1.6_

- [ ] 19. Implement Patient Registration Service
  - Create `PatientRegistrationService` class
  - Orchestrate registration workflow (validate → check duplicates → generate MR → save)
  - Implement NIK format validation (16 digits)
  - Implement BPJS number uniqueness validation
  - Fire `PatientRegistered` event after successful registration
  - Handle patient photo upload with validation
  - **Files to create:** `app/Services/PatientRegistrationService.php`, `app/Events/PatientRegistered.php`, `app/Http/Requests/PatientRegistrationRequest.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 1_

- [ ] 20. Create Patient Registration Controller and Views
  - Create `PatientController` with CRUD operations
  - Create patient registration form with Livewire real-time validation
  - Create patient search interface with autocomplete
  - Create patient profile view with visit history
  - Implement photo upload with preview
  - Add duplicate patient warning modal
  - **Files to create:** `app/Http/Controllers/PatientController.php`, `app/Livewire/PatientRegistrationForm.php`, `resources/views/patients/create.blade.php`, `resources/views/patients/show.blade.php`, `app/Livewire/PatientSearch.php`
  - **Estimated time:** 3 days
  - _Requirements: Req 1_

- [ ] 21. Implement Queue Management Models
  - Create `Queue` model with status tracking
  - Create `QueueCounter` model for daily sequence management
  - Define queue statuses (waiting, called, serving, completed, cancelled)
  - Create relationships with patients and departments
  - **Files to create:** `app/Models/Queue.php`, `app/Models/QueueCounter.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 2_

- [ ] 22. Implement Queue Management Service
  - Create `QueueManagementService` class
  - Implement queue number generation by department
  - Implement queue advancement (call next)
  - Implement queue status updates
  - Implement daily queue reset at end of operating hours
  - Track queue waiting time and service time metrics
  - **Files to create:** `app/Services/QueueManagementService.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 2_

- [ ] 23. Create Queue Display System with Real-time Updates
  - Create `QueueController` for queue operations
  - Create Livewire component for queue display board
  - Implement WebSocket broadcasting for real-time updates
  - Create queue ticket generation with QR code
  - Create staff queue management interface
  - Implement audio call notification (optional)
  - **Files to create:** `app/Http/Controllers/QueueController.php`, `app/Livewire/QueueDisplay.php`, `app/Livewire/QueueManagement.php`, `resources/views/queue/display.blade.php`, `app/Events/QueueNumberCalled.php`
  - **Estimated time:** 3 days
  - _Requirements: Req 2_

- [ ] 24. Checkpoint - Test Patient Registration and Queue System
  - Test complete patient registration workflow
  - Test duplicate detection with NIK and BPJS
  - Test MR number uniqueness across concurrent registrations
  - Test queue generation and advancement
  - Test real-time queue display updates
  - Ensure all tests pass, ask the user if questions arise.

### Phase 3: External Integrations

- [ ] 25. Implement BPJS VClaim API Client
  - Create `BpjsVClaimClient` base class with authentication
  - Implement HMAC-SHA256 signature generation
  - Implement request/response handling with retry logic
  - Configure BPJS credentials in config file
  - Add connection timeout and error handling
  - Create `BpjsConnectionException` and `BpjsException` classes
  - **Files to create:** `app/Services/Integration/BPJS/BpjsVClaimClient.php`, `app/Exceptions/BpjsConnectionException.php`, `app/Exceptions/BpjsException.php`, `config/bpjs.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 3, 28_

- [ ] 26. Implement BPJS Eligibility Verification Service
  - Create `BpjsEligibilityService` class
  - Implement patient eligibility check via VClaim API
  - Parse and validate eligibility response
  - Handle inactive/ineligible patients
  - Cache eligibility results for 24 hours
  - **Files to create:** `app/Services/Integration/BPJS/BpjsEligibilityService.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 3_

- [ ] 27. Implement BPJS SEP (Eligibility Letter) Management
  - Create `Sep` model for storing SEP data
  - Create `BpjsSepService` class
  - Implement SEP creation via VClaim API
  - Implement SEP deletion and update within allowed timeframe
  - Handle SEP creation failures with manual entry fallback
  - Link SEP to visit records
  - **Files to create:** `app/Models/Sep.php`, `app/Services/Integration/BPJS/BpjsSepService.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 3_

- [ ] 28. Implement BPJS Claim Submission Service
  - Create `BpjsClaim` model for tracking claims
  - Create `BpjsClaimService` class
  - Generate claim files in VClaim-compatible format
  - Implement claim submission via VClaim API
  - Track claim status (submitted, accepted, rejected, paid)
  - Handle claim rejection with resubmission capability
  - **Files to create:** `app/Models/BpjsClaim.php`, `app/Services/Integration/BPJS/BpjsClaimService.php`, `app/Jobs/SubmitBpjsClaim.php`
  - **Estimated time:** 3 days
  - _Requirements: Req 28_

- [ ] 29. Create BPJS Reference Data Sync Job
  - Create scheduled job to sync BPJS reference data (diagnoses, procedures, facilities)
  - Sync national formulary updates
  - Update local database with BPJS data
  - Log sync results and errors
  - **Files to create:** `app/Jobs/SyncBpjsReferenceData.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 38_

- [ ] 30. Implement SATUSEHAT FHIR Client
  - Create `SatuSehatFhirClient` class with OAuth2 authentication
  - Implement FHIR API request handling
  - Configure SATUSEHAT credentials
  - Add retry logic with exponential backoff
  - Create `SatuSehatSubmissionException` class
  - **Files to create:** `app/Services/Integration/SatuSehat/SatuSehatFhirClient.php`, `app/Services/Integration/SatuSehat/SatuSehatAuthService.php`, `app/Exceptions/SatuSehatSubmissionException.php`, `config/satusehat.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 29_

- [ ] 31. Implement FHIR Resource Mapper
  - Create `FhirMapper` class for EMR to FHIR conversion
  - Implement Patient resource mapping
  - Implement Encounter resource mapping
  - Implement Condition (diagnosis) resource mapping
  - Implement Observation (vital signs, lab results) resource mapping
  - Implement MedicationRequest resource mapping
  - **Files to create:** `app/Services/Integration/SatuSehat/FhirMapper.php`
  - **Estimated time:** 3 days
  - _Requirements: Req 29_

- [ ]* 31.1. Write property test for FHIR serialization round-trip
  - **Property 2: FHIR Serialization Preserves Data**
  - **Validates: Requirements 29.1, 29.2**
  - Test Patient mapping to FHIR and verify data preservation
  - Test Encounter mapping to FHIR
  - Generate random valid patient data and ensure mapping is consistent
  - **Files to create:** `tests/PropertyBased/FhirSerializationPropertyTest.php`
  - **Estimated time:** 0.5 days

- [ ] 32. Implement SATUSEHAT Submission Service
  - Create `SatuSehatSubmission` model for tracking submissions
  - Create `SatuSehatSubmissionService` class
  - Queue encounter submissions for background processing
  - Handle submission failures with retry queue
  - Store submission confirmation IDs
  - Generate submission status reports
  - **Files to create:** `app/Models/SatuSehatSubmission.php`, `app/Services/Integration/SatuSehat/SatuSehatSubmissionService.php`, `app/Jobs/SubmitEncounterToSatuSehat.php`, `app/Jobs/RetryFailedSubmissions.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 29_

- [ ] 33. Implement HL7 Message Parser for Laboratory Equipment
  - Create `Hl7ResultParser` class
  - Parse HL7 OBX segments for lab results
  - Map HL7 abnormal flags to system flags
  - Handle multiple result segments
  - Create `Hl7ParseException` for malformed messages
  - **Files to create:** `app/Services/Integration/Hl7/Hl7ResultParser.php`, `app/Exceptions/Hl7ParseException.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 7.4 (Lab instrument bridging)_

- [ ]* 33.1. Write property test for HL7 message parsing
  - **Property 3: HL7 Parse-Serialize Round Trip**
  - **Validates: Requirements 7.4**
  - Generate valid HL7 OBX messages
  - Test parsing then serializing returns equivalent data
  - Test with multiple result segments
  - **Files to create:** `tests/PropertyBased/Hl7ParserPropertyTest.php`
  - **Estimated time:** 0.5 days

- [ ] 34. Checkpoint - Test External Integrations
  - Test BPJS eligibility verification with test credentials
  - Test SEP creation and deletion
  - Test SATUSEHAT authentication and submission
  - Test FHIR resource mapping accuracy
  - Test HL7 message parsing with sample messages
  - Ensure all tests pass, ask the user if questions arise.

### Phase 4: Clinical Modules - Outpatient

- [ ] 35. Create Outpatient Visit Models and Relationships
  - Create `OutpatientVisit` model extending `RawatJalan`
  - Create `VitalSigns` model with polymorphic relationship
  - Create `Diagnosis` model with ICD-10 codes
  - Create `Procedure` model with ICD-9-CM codes
  - Define all relationships between models
  - **Files to create:** `app/Models/OutpatientVisit.php`, `app/Models/VitalSigns.php`, `app/Models/Diagnosis.php`, `app/Models/Procedure.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 4, 5_

- [ ] 36. Implement ICD Code Search Service
  - Create `IcdSearchService` class
  - Implement ICD-10 diagnosis code search with autocomplete
  - Implement ICD-9-CM procedure code search
  - Cache frequently searched codes
  - Support search by code or description
  - **Files to create:** `app/Services/IcdSearchService.php`, `app/Repositories/IcdRepository.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 5.2, 5.4_

- [ ] 37. Implement Vital Signs Recording Service
  - Create `VitalSignsService` class
  - Implement vital signs validation and storage
  - Calculate BMI from height and weight
  - Check vital signs against normal ranges by age group
  - Trigger warnings for out-of-range values
  - **Files to create:** `app/Services/VitalSignsService.php`, `app/Services/VitalSignsValidationService.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 4_

- [ ] 38. Implement SOAP Documentation Service
  - Create `SoapDocumentationService` class
  - Implement SOAP note creation and update
  - Validate diagnosis code requirement
  - Support copying previous SOAP notes as templates
  - Update visit status to "Examined" on completion
  - **Files to create:** `app/Services/SoapDocumentationService.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 5_

- [ ] 39. Create Outpatient Visit Controller and Views
  - Create `OutpatientVisitController` with visit workflow
  - Create Livewire component for SOAP documentation form
  - Create vital signs input form with real-time BMI calculation
  - Create ICD code search component with autocomplete
  - Create visit history timeline view
  - Implement specialty-specific assessment templates
  - **Files to create:** `app/Http/Controllers/OutpatientVisitController.php`, `app/Livewire/SoapDocumentationForm.php`, `app/Livewire/VitalSignsForm.php`, `app/Livewire/IcdCodeSearch.php`, `resources/views/outpatient/visit.blade.php`
  - **Estimated time:** 4 days
  - _Requirements: Req 4, 5_

- [ ]* 39.1. Write unit tests for outpatient services
  - Test SOAP documentation creation
  - Test vital signs validation and BMI calculation
  - Test ICD code search functionality
  - Test visit status transitions
  - **Files to create:** `tests/Unit/SoapDocumentationServiceTest.php`, `tests/Unit/VitalSignsServiceTest.php`
  - **Estimated time:** 1 day

### Phase 4: Clinical Modules - Laboratory

- [ ] 40. Create Laboratory Models
  - Create `LabOrder` model with status tracking
  - Create `LabOrderItem` model for individual tests
  - Create `LabResult` model with normal range flagging
  - Create `LabTestCatalog` model with test definitions
  - Create `LabTestTemplate` model for predefined panels
  - Define all model relationships
  - **Files to create:** `app/Models/LabOrder.php`, `app/Models/LabOrderItem.php`, `app/Models/LabResult.php`, `app/Models/LabTestCatalog.php`, `app/Models/LabTestTemplate.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 6, 7_

- [ ] 41. Implement Lab Order Service
  - Create `LabOrderService` class
  - Implement order creation with unique order number generation
  - Support test template selection
  - Support individual test selection
  - Generate barcode labels for specimens
  - Send order to laboratory queue with real-time notification
  - **Files to create:** `app/Services/LabOrderService.php`, `app/Events/LabOrderCreated.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 6_

- [ ] 42. Implement Lab Result Entry Service
  - Create `LabResultService` class
  - Implement result entry with data type validation
  - Implement automatic normal range flagging by age and gender
  - Support HL7 result import from instruments
  - Require analyst verification before publication
  - Trigger critical value alerts
  - **Files to create:** `app/Services/LabResultService.php`, `app/Services/LabNormalRangeService.php`, `app/Services/CriticalValueAlertService.php`
  - **Estimated time:** 3 days
  - _Requirements: Req 7_

- [ ] 43. Implement Lab Report Generation Service
  - Create `LabReportGeneratorService` class
  - Generate PDF reports with hospital branding
  - Include QR code for report verification
  - Display result history with graphical trends
  - Support email and WhatsApp delivery with patient consent
  - Require physician approval before patient release
  - **Files to create:** `app/Services/LabReportGeneratorService.php`, `resources/views/reports/lab-result.blade.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 8_

- [ ] 44. Create Laboratory Controllers and Views
  - Create `LabOrderController` for test ordering
  - Create `LabResultController` for result entry and viewing
  - Create Livewire component for lab order form with template selection
  - Create Livewire component for result entry with validation
  - Create result viewing interface with trend graphs
  - Create specimen tracking interface
  - **Files to create:** `app/Http/Controllers/LabOrderController.php`, `app/Http/Controllers/LabResultController.php`, `app/Livewire/LabOrderForm.php`, `app/Livewire/LabResultEntry.php`, `resources/views/laboratory/order.blade.php`, `resources/views/laboratory/results.blade.php`
  - **Estimated time:** 4 days
  - _Requirements: Req 6, 7, 8_

- [ ]* 44.1. Write unit tests for laboratory services
  - Test lab order creation and queue notification
  - Test result entry and normal range flagging
  - Test critical value detection and alerting
  - Test report generation
  - **Files to create:** `tests/Unit/LabOrderServiceTest.php`, `tests/Unit/LabResultServiceTest.php`
  - **Estimated time:** 1 day

### Phase 4: Clinical Modules - Pharmacy

- [ ] 45. Create Pharmacy Models
  - Create `Prescription` model extending existing `Resep`
  - Create `PrescriptionItem` model extending `ResepDetail`
  - Create `DrugBatch` model for FIFO inventory
  - Create `DrugInteraction` model with severity levels
  - Create `PrescriptionVerification` model
  - Create `DrugStockMovement` model
  - **Files to create:** `app/Models/Prescription.php`, `app/Models/PrescriptionItem.php`, `app/Models/DrugBatch.php`, `app/Models/DrugInteraction.php`, `app/Models/PrescriptionVerification.php`, `app/Models/DrugStockMovement.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 11, 12, 13_

- [ ] 46. Implement Drug Interaction Checking Service
  - Create `DrugInteractionService` class
  - Check new prescriptions against active medications
  - Check drug-drug interactions for all combinations
  - Return interactions sorted by severity (contraindicated, major, moderate, minor)
  - Display warnings with clinical recommendations
  - **Files to create:** `app/Services/DrugInteractionService.php`, `app/Exceptions/DrugInteractionException.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 11_

- [ ] 47. Implement Prescription Service
  - Create `PrescriptionService` class
  - Orchestrate prescription workflow with drug interaction checking
  - Validate dose, frequency, and route
  - Calculate total medication quantity
  - Support prescription templates for common conditions
  - Send prescription to pharmacy queue
  - Generate prescription labels
  - **Files to create:** `app/Services/PrescriptionService.php`, `app/Events/PrescriptionCreated.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 11_

- [ ] 48. Implement Pharmacy Dispensing Service
  - Create `PharmacyDispensingService` class
  - Display pending prescriptions in pharmacy queue
  - Verify medication availability and stock levels
  - Require pharmacist verification and digital signature
  - Automatically deduct dispensed quantities using FIFO
  - Handle insufficient stock with alternative suggestions
  - Require double-check for high-alert medications
  - Document patient counseling
  - **Files to create:** `app/Services/PharmacyDispensingService.php`, `app/Services/DrugInventoryService.php`
  - **Estimated time:** 3 days
  - _Requirements: Req 12_

- [ ] 49. Implement Drug Inventory Management Service
  - Create `DrugInventoryService` class
  - Track stock across multiple storage locations
  - Implement FIFO stock rotation during dispensing
  - Track batch numbers and expiration dates
  - Generate alerts for low stock and expiring medications
  - Support stock transfers between locations with approval
  - Generate LPLPO reports
  - **Files to create:** `app/Services/DrugInventoryService.php`, `app/Services/DrugFormularyService.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 13, 38_

- [ ] 50. Create Pharmacy Controllers and Views
  - Create `PrescriptionController` for prescribing
  - Create `PharmacyDispensingController` for dispensing workflow
  - Create `DrugInventoryController` for stock management
  - Create Livewire component for prescription form with drug search
  - Create Livewire component for drug interaction warnings
  - Create pharmacy queue display with real-time updates
  - Create dispensing interface with stock visibility
  - Create inventory management interface
  - **Files to create:** `app/Http/Controllers/PrescriptionController.php`, `app/Http/Controllers/PharmacyDispensingController.php`, `app/Http/Controllers/DrugInventoryController.php`, `app/Livewire/PrescriptionForm.php`, `app/Livewire/PharmacyQueue.php`, `resources/views/pharmacy/prescribe.blade.php`, `resources/views/pharmacy/dispense.blade.php`
  - **Estimated time:** 5 days
  - _Requirements: Req 11, 12, 13_

- [ ]* 50.1. Write unit tests for pharmacy services
  - Test drug interaction checking with multiple medications
  - Test prescription creation and validation
  - Test FIFO stock deduction
  - Test low stock and expiry alerts
  - **Files to create:** `tests/Unit/DrugInteractionServiceTest.php`, `tests/Unit/PharmacyDispensingServiceTest.php`
  - **Estimated time:** 1 day

- [ ] 51. Checkpoint - Test Clinical Modules (Outpatient, Lab, Pharmacy)
  - Test complete outpatient visit workflow with SOAP documentation
  - Test lab order creation, result entry, and reporting
  - Test prescription creation with drug interaction checking
  - Test pharmacy dispensing with stock management
  - Verify real-time queue updates work correctly
  - Ensure all tests pass, ask the user if questions arise.

### Phase 4: Clinical Modules - Inpatient

- [ ] 52. Create Inpatient Models
  - Create `InpatientAdmission` model extending `RawatInap`
  - Create `CpptEntry` model for integrated progress notes
  - Create `FluidBalanceRecord` model with calculated balance
  - Create `NursingAssessment` model with risk scoring
  - Create `DischargeSummary` model
  - Create `BedTransfer` model
  - **Files to create:** `app/Models/InpatientAdmission.php`, `app/Models/CpptEntry.php`, `app/Models/FluidBalanceRecord.php`, `app/Models/NursingAssessment.php`, `app/Models/DischargeSummary.php`, `app/Models/BedTransfer.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 14, 15, 16, 17, 23_

- [ ] 53. Implement Bed Allocation Service
  - Create `BedAllocationService` class
  - Display real-time bed availability by ward and room
  - Assign bed and update status to "Occupied"
  - Prevent double bed assignment with validation
  - Support bed transfer with transfer reason documentation
  - Update bed status on discharge
  - **Files to create:** `app/Services/BedAllocationService.php`, `app/Exceptions/BedUnavailableException.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 14_

- [ ] 54. Implement Inpatient Admission Service
  - Create `InpatientAdmissionService` class
  - Orchestrate admission workflow (validate → assign bed → create admission)
  - Generate unique inpatient registration number
  - Calculate admission deposit by insurance class and estimated LOS
  - Capture admission diagnosis and admitting physician
  - Require initial assessment completion within 24 hours
  - **Files to create:** `app/Services/InpatientAdmissionService.php`, `app/Events/PatientAdmitted.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 14, 15_

- [ ] 55. Implement CPPT Documentation Service
  - Create `CpptDocumentationService` class
  - Support multi-disciplinary entries (physician, nurse, nutritionist, pharmacist, therapist)
  - Display entries in chronological order with author identification
  - Support SOAP format for physician notes
  - Support shift-based nursing observations
  - Integrate with active orders and care plans display
  - Require authentication before viewing or editing
  - **Files to create:** `app/Services/CpptDocumentationService.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 16_

- [ ] 56. Implement Fluid Balance Tracking Service
  - Create `FluidBalanceService` class
  - Track intake sources (oral, IV, blood products)
  - Track output sources (urine, drain, vomit)
  - Automatically calculate total intake, output, and balance
  - Generate fluid balance flowsheet with cumulative calculations
  - Support shift-based or hourly recording
  - **Files to create:** `app/Services/FluidBalanceService.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 17_

- [ ] 57. Implement Nursing Assessment Service
  - Create `NursingAssessmentService` class
  - Support initial and shift assessments
  - Implement risk assessment tools (Fall Risk, MEOWS, Suicide Risk, Pressure Ulcer)
  - Automatically calculate risk scores from inputs
  - Generate high-risk alerts when thresholds exceeded
  - Support condition-specific templates (Adult, Infant, Geriatric)
  - **Files to create:** `app/Services/NursingAssessmentService.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 15_

- [ ] 58. Implement Discharge Service
  - Create `DischargeService` class
  - Generate discharge summary with admission/discharge diagnoses
  - Document hospital course and procedures performed
  - Specify discharge disposition and follow-up plan
  - Generate discharge medications and prescriptions
  - Update bed status to "Available" within 1 minute
  - Calculate final LOS and trigger billing finalization
  - Require patient/family signature acknowledgment
  - **Files to create:** `app/Services/DischargeService.php`, `app/Events/DischargeCompleted.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 23_

- [ ] 59. Create Inpatient Controllers and Views
  - Create `InpatientAdmissionController` for admission workflow
  - Create `BedManagementController` for bed tracking
  - Create `CpptController` for progress notes
  - Create Livewire component for bed availability display
  - Create Livewire component for CPPT entry form
  - Create Livewire component for fluid balance tracking
  - Create nursing assessment forms
  - Create discharge documentation form
  - **Files to create:** `app/Http/Controllers/InpatientAdmissionController.php`, `app/Http/Controllers/BedManagementController.php`, `app/Http/Controllers/CpptController.php`, `app/Livewire/BedAvailability.php`, `app/Livewire/CpptEntry.php`, `resources/views/inpatient/admission.blade.php`, `resources/views/inpatient/cppt.blade.php`
  - **Estimated time:** 5 days
  - _Requirements: Req 14, 15, 16, 17, 23_

- [ ]* 59.1. Write unit tests for inpatient services
  - Test bed allocation and double-booking prevention
  - Test admission workflow and deposit calculation
  - Test CPPT entry creation by different providers
  - Test fluid balance calculation accuracy
  - Test discharge workflow and bed status update
  - **Files to create:** `tests/Unit/BedAllocationServiceTest.php`, `tests/Unit/FluidBalanceServiceTest.php`
  - **Estimated time:** 1 day

### Phase 4: Clinical Modules - Radiology

- [ ] 60. Create Radiology Models
  - Create `RadiologyOrder` model with scheduling
  - Create `RadiologyOrderItem` model for individual examinations
  - Create `RadiologyReport` model with findings
  - Create `DicomImage` model for image storage
  - **Files to create:** `app/Models/RadiologyOrder.php`, `app/Models/RadiologyOrderItem.php`, `app/Models/RadiologyReport.php`, `app/Models/DicomImage.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 9, 10_

- [ ] 61. Implement Radiology Order Service
  - Create `RadiologyOrderService` class
  - Generate unique radiology request number
  - Support examination selection by modality
  - Require clinical indication and patient history
  - Support scheduling with equipment availability validation
  - Send orders to radiology queue in real-time
  - Flag orders requiring contrast media
  - **Files to create:** `app/Services/RadiologyOrderService.php`, `app/Events/RadiologyOrderCreated.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 9_

- [ ] 62. Implement Radiology Reporting Service
  - Create `RadiologyReportingService` class
  - Support DICOM image upload (up to 100MB per study)
  - Support JPEG image upload as alternative
  - Provide examination-specific report templates
  - Require radiologist digital signature
  - Generate printable reports with representative images
  - Support PACS integration (optional)
  - **Files to create:** `app/Services/RadiologyReportingService.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 10_

- [ ] 63. Create Radiology Controllers and Views
  - Create `RadiologyOrderController` for ordering
  - Create `RadiologyReportController` for reporting
  - Create radiology order form with modality selection
  - Create scheduling interface with calendar view
  - Create report entry form with image upload
  - Create DICOM image viewer with zoom and window/level controls
  - **Files to create:** `app/Http/Controllers/RadiologyOrderController.php`, `app/Http/Controllers/RadiologyReportController.php`, `resources/views/radiology/order.blade.php`, `resources/views/radiology/report.blade.php`
  - **Estimated time:** 3 days
  - _Requirements: Req 9, 10_

### Phase 4: Clinical Modules - Emergency Department

- [ ] 64. Create Emergency Department Models
  - Create `EmergencyVisit` model with triage
  - Create `TriageAssessment` model with color-coded priority
  - Create `TraumaScore` model (GCS, RTS)
  - **Files to create:** `app/Models/EmergencyVisit.php`, `app/Models/TriageAssessment.php`, `app/Models/TraumaScore.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 21, 22_

- [ ] 65. Implement Emergency Triage Service
  - Create `EmergencyTriageService` class
  - Assign triage level using color codes (Red, Yellow, Green, Black)
  - Calculate trauma scores (GCS, RTS) automatically
  - Trigger immediate physician notification for Red level
  - Support re-triage with history tracking
  - Track time from triage to physician evaluation
  - **Files to create:** `app/Services/EmergencyTriageService.php`, `app/Events/CriticalTriageDetected.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 21_

- [ ] 66. Implement Emergency Patient Tracking Service
  - Create `EmergencyTrackingService` class
  - Track patient status (Triage, Examination, Laboratory, Radiology, Observation, Discharge, Admission)
  - Track patient location within emergency department
  - Track disposition (Discharge Home, Admit, Transfer, LWAMA, Deceased)
  - Calculate emergency department LOS
  - Broadcast real-time status updates within 2 seconds
  - Alert charge nurse when patients exceed target time thresholds
  - **Files to create:** `app/Services/EmergencyTrackingService.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 22_

- [ ] 67. Create Emergency Department Controllers and Views
  - Create `EmergencyVisitController` for ED workflow
  - Create triage assessment form with priority assignment
  - Create emergency patient board with real-time updates
  - Create location assignment interface
  - Generate daily emergency census reports
  - **Files to create:** `app/Http/Controllers/EmergencyVisitController.php`, `app/Livewire/EmergencyPatientBoard.php`, `resources/views/emergency/triage.blade.php`, `resources/views/emergency/board.blade.php`
  - **Estimated time:** 3 days
  - _Requirements: Req 21, 22_

### Phase 4: Clinical Modules - Operating Room

- [ ] 68. Create Operating Room Models
  - Create `OperatingRoomSchedule` model with team assignments
  - Create `SurgicalProcedure` model with operative findings
  - Create `AnesthesiaRecord` model
  - Create `SurgicalChecklist` model (WHO Safety Checklist)
  - **Files to create:** `app/Models/OperatingRoomSchedule.php`, `app/Models/SurgicalProcedure.php`, `app/Models/AnesthesiaRecord.php`, `app/Models/SurgicalChecklist.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 18, 19, 20_

- [ ] 69. Implement Operating Room Scheduling Service
  - Create `OperatingRoomSchedulingService` class
  - Display OR availability calendar with time slots
  - Assign surgeon, anesthesiologist, assisting surgeons, nursing staff
  - Validate staff availability during scheduled time
  - Prevent double-booking of operating rooms
  - Support emergency case insertion with bump workflow
  - Generate daily OR schedule reports
  - Notify team members of schedule changes in real-time
  - **Files to create:** `app/Services/OperatingRoomSchedulingService.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 19_

- [ ] 70. Implement Surgical Safety Checklist Service
  - Create `SurgicalChecklistService` class
  - Implement WHO Surgical Safety Checklist (Sign In, Time Out, Sign Out)
  - Require completion of each phase before proceeding
  - Capture team member signatures
  - Prevent proceeding if safety concerns identified
  - Include instrument count verification with discrepancy documentation
  - **Files to create:** `app/Services/SurgicalChecklistService.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 18_

- [ ] 71. Implement Surgical Reporting Service
  - Create `SurgicalReportingService` class
  - Provide operative report templates by surgical specialty
  - Capture pre-op diagnosis, post-op diagnosis, procedure, findings, complications
  - Integrate ICD-9-CM procedure coding for billing
  - Provide anesthesia record with agents and monitoring
  - Track surgical duration (incision to closure)
  - Support implant documentation with lot numbers
  - Require surgeon and anesthesiologist digital signatures
  - Make report available to inpatient team within 5 minutes
  - **Files to create:** `app/Services/SurgicalReportingService.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 20_

- [ ] 72. Create Operating Room Controllers and Views
  - Create `OperatingRoomScheduleController` for scheduling
  - Create `SurgicalProcedureController` for documentation
  - Create OR calendar interface with drag-and-drop scheduling
  - Create surgical safety checklist forms
  - Create operative report form
  - Create anesthesia record form
  - **Files to create:** `app/Http/Controllers/OperatingRoomScheduleController.php`, `app/Http/Controllers/SurgicalProcedureController.php`, `resources/views/operating-room/schedule.blade.php`, `resources/views/operating-room/checklist.blade.php`
  - **Estimated time:** 3 days
  - _Requirements: Req 18, 19, 20_

- [ ] 73. Checkpoint - Test All Clinical Modules
  - Test inpatient admission, CPPT documentation, and discharge
  - Test radiology order and reporting with image upload
  - Test emergency triage and patient tracking
  - Test OR scheduling and surgical checklists
  - Verify all real-time updates work correctly
  - Ensure all tests pass, ask the user if questions arise.

### Phase 5: Financial Modules

- [ ] 74. Create Billing Models
  - Create `Invoice` model extending `Billing`
  - Create `InvoiceItem` model for itemized charges
  - Create `Payment` model with multi-method support
  - Create `Tariff` model with insurance class pricing
  - **Files to create:** `app/Models/Invoice.php`, `app/Models/InvoiceItem.php`, `app/Models/Payment.php`, `app/Models/Tariff.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 24, 25_

- [ ] 75. Implement Billing Calculation Service
  - Create `BillingCalculationService` class
  - Aggregate charges from consultations, procedures, medications, lab tests, radiology, room, nursing
  - Apply pricing based on insurance class (General, BPJS 1/2/3, Private)
  - Calculate daily room charges from admission to discharge
  - Support discounts with reason documentation
  - Support payment deposit deduction
  - Round total charges per hospital policy
  - Separate BPJS-covered and non-covered items per formulary
  - **Files to create:** `app/Services/BillingCalculationService.php`, `app/Services/PricingService.php`, `app/Services/BpjsClaimSeparationService.php`
  - **Estimated time:** 3 days
  - _Requirements: Req 24_

- [ ] 76. Implement Payment Processing Service
  - Create `PaymentProcessingService` class
  - Support multiple payment methods (Cash, Debit, Credit, Bank Transfer, Mixed)
  - Generate official receipt with receipt number and hospital stamp
  - Support partial payments with remaining balance tracking
  - Validate payment amount matches invoice total or document variance
  - Support payment cancellation with supervisor approval
  - Update patient account status from "Outstanding" to "Paid"
  - Generate daily cashier closing report with reconciliation
  - Support receipt reprinting with audit trail logging
  - **Files to create:** `app/Services/PaymentProcessingService.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 25_

- [ ] 77. Create Billing Controllers and Views
  - Create `BillingController` for invoice generation
  - Create `PaymentController` for payment processing
  - Create invoice generation interface with itemized charges
  - Create payment processing interface with multi-method support
  - Create receipt printing template
  - Create cashier closing report
  - **Files to create:** `app/Http/Controllers/BillingController.php`, `app/Http/Controllers/PaymentController.php`, `resources/views/billing/invoice.blade.php`, `resources/views/billing/payment.blade.php`, `resources/views/reports/receipt.blade.php`
  - **Estimated time:** 3 days
  - _Requirements: Req 24, 25_

- [ ]* 77.1. Write unit tests for billing services
  - Test charge aggregation from all modules
  - Test insurance class pricing application
  - Test room charge calculation for multi-day stays
  - Test BPJS claim separation
  - Test payment processing with mixed methods
  - **Files to create:** `tests/Unit/BillingCalculationServiceTest.php`, `tests/Unit/PaymentProcessingServiceTest.php`
  - **Estimated time:** 1 day

### Phase 6: Medical Records & Reporting

- [ ] 78. Create Medical Record Models
  - Create `ActiveProblem` model for current patient issues
  - Create `Allergy` model with severity tracking
  - Create `UploadedDocument` model for scanned files
  - Create `MedicalRecordAccessLog` model for audit trail
  - **Files to create:** `app/Models/ActiveProblem.php`, `app/Models/Allergy.php`, `app/Models/UploadedDocument.php`, `app/Models/MedicalRecordAccessLog.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 26, 32_

- [ ] 79. Implement Medical Record Aggregation Service
  - Create `MedicalRecordAggregationService` class
  - Aggregate data from outpatient, inpatient, emergency, lab, radiology, medications
  - Display patient EMR in chronological timeline view
  - Support filtered views by encounter type, date range, diagnosis, provider
  - Display active problems, allergies, current medications prominently
  - Generate clinical summary for referrals and continuity of care
  - Enforce role-based access control with audit logging
  - **Files to create:** `app/Services/MedicalRecordAggregationService.php`, `app/Services/ClinicalSummaryGeneratorService.php`, `app/Services/MedicalRecordAccessLogService.php`
  - **Estimated time:** 3 days
  - _Requirements: Req 26_

- [ ] 80. Implement Document Upload and Indexing Service
  - Create `DocumentIndexingService` class
  - Support document scanning and upload with categorization
  - Support document types (lab, radiology, referral, consent, insurance, other)
  - Store documents in S3/MinIO storage
  - Track upload metadata (date, uploader, file size)
  - Support OCR for scanned documents (optional)
  - **Files to create:** `app/Services/DocumentIndexingService.php`
  - **Estimated time:** 1 day
  - _Requirements: Req 26.4_

- [ ] 81. Implement Medical Record Coding Service
  - Create `MedicalRecordCodingService` class
  - Provide coding interface with discharge summaries and operative reports
  - Support multiple ICD-10 diagnosis codes with principal designation
  - Support ICD-9-CM procedure coding
  - Validate code format and existence in current code set
  - Generate RL (Hospital Report) 1-6 for government submission
  - Generate top 10 disease and procedure reports by frequency
  - Calculate hospital statistics (BOR, LOS, TOI, BTO, GDR)
  - **Files to create:** `app/Services/MedicalRecordCodingService.php`, `app/Services/HospitalStatisticsService.php`
  - **Estimated time:** 3 days
  - _Requirements: Req 27_

- [ ] 82. Implement Report Generation System
  - Create `ReportGeneratorService` class
  - Provide pre-defined templates (daily census, admission/discharge stats, revenue)
  - Support custom report parameters (date range, department, provider)
  - Export reports in PDF, Excel, CSV formats
  - Generate graphical visualizations (bar charts, line graphs, pie charts)
  - Schedule automatic report generation and email delivery
  - Provide dashboard with KPIs refreshed in real-time
  - Support drill-down from summary to detailed transactions
  - Calculate financial metrics (revenue by service, payer mix, provider productivity)
  - **Files to create:** `app/Services/ReportGeneratorService.php`, `app/Http/Controllers/ReportController.php`
  - **Estimated time:** 4 days
  - _Requirements: Req 37_

- [ ] 83. Create Medical Record and Reporting Controllers and Views
  - Create `MedicalRecordController` for EMR viewing
  - Create `DocumentUploadController` for document management
  - Create `ClinicalSummaryController` for summary generation
  - Create EMR timeline view with filtering
  - Create document upload interface with categorization
  - Create coding interface for discharge records
  - Create report generation interface with parameter selection
  - Create dashboard with KPI widgets
  - **Files to create:** `app/Http/Controllers/MedicalRecordController.php`, `app/Http/Controllers/DocumentUploadController.php`, `app/Http/Controllers/ClinicalSummaryController.php`, `resources/views/medical-record/timeline.blade.php`, `resources/views/reports/dashboard.blade.php`
  - **Estimated time:** 4 days
  - _Requirements: Req 26, 27, 37_

### Phase 7: Additional Features

- [ ] 84. Implement Infection Control Monitoring
  - Create `InfectionControl` model with isolation precautions
  - Create infection monitoring service
  - Flag patients with confirmed or suspected infections
  - Display visible alerts on patient banner for isolation precautions
  - Track healthcare-associated infection cases
  - Generate infection surveillance reports by unit and organism
  - Calculate infection rates per 1000 patient days
  - Alert infection control team for clusters
  - **Files to create:** `app/Models/InfectionControl.php`, `app/Services/InfectionControlService.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 39_

- [ ] 85. Implement Clinical Decision Support
  - Create `ClinicalDecisionSupportService` class
  - Check medication allergies before prescription finalization
  - Block prescriptions for documented allergies with override justification
  - Provide dosing guidance for weight-based and renal-adjusted medications
  - Alert for duplicate therapy from same therapeutic class
  - Provide evidence-based order sets for common conditions
  - Alert for missing preventive care (VTE prophylaxis, fall prevention)
  - Support customizable alert rules by hospital guidelines
  - Track alert override rates
  - **Files to create:** `app/Services/ClinicalDecisionSupportService.php`
  - **Estimated time:** 3 days
  - _Requirements: Req 40_

- [ ] 86. Implement Staff Management and Scheduling
  - Create `Staff` model with credentials tracking
  - Create staff scheduling system with shift templates
  - Alert staff and supervisors for credential expiration (30 days)
  - Validate no double-scheduling during same time period
  - Integrate with biometric attendance devices
  - Calculate working hours, overtime, leave balances
  - Display current on-call staff by department
  - **Files to create:** `app/Models/Staff.php`, `app/Services/StaffSchedulingService.php`, `app/Http/Controllers/StaffController.php`
  - **Estimated time:** 3 days
  - _Requirements: Req 30_

- [ ] 87. Implement Asset and Equipment Management
  - Create `Asset` model with maintenance tracking
  - Track medical equipment with ID, model, serial number, purchase date, location
  - Track maintenance history (preventive and repairs)
  - Schedule preventive maintenance based on recommendations
  - Alert biomedical staff when maintenance due (7 days)
  - Track calibration due dates
  - Track equipment status (Available, In Use, Under Maintenance, Retired)
  - Calculate depreciation for financial reporting
  - Support incident reporting for equipment failures
  - **Files to create:** `app/Models/Asset.php`, `app/Services/AssetManagementService.php`, `app/Http/Controllers/AssetController.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 31_

- [ ] 88. Implement Database Backup and Recovery System
  - Configure automated full database backup daily during off-peak hours
  - Configure incremental backups every 6 hours
  - Validate backup integrity after completion
  - Retry failed backups up to 3 times with administrator alerts
  - Retain daily backups for 30 days, monthly for 1 year
  - Support point-in-time recovery using transaction logs
  - Store backups in redundant locations including off-site
  - Document and test restore procedures
  - **Files to create:** `app/Console/Commands/BackupDatabase.php`, `app/Console/Commands/ValidateBackup.php`
  - **Estimated time:** 2 days
  - _Requirements: Req 34_

### Phase 7: Testing

- [ ]* 89. Write Unit Tests for Core Services
  - Test patient registration service with duplicate detection
  - Test MR number generation uniqueness
  - Test queue management service
  - Test BPJS eligibility verification (mocked)
  - Test SATUSEHAT FHIR mapping
  - **Files to create:** `tests/Unit/PatientRegistrationServiceTest.php`, `tests/Unit/QueueManagementServiceTest.php`, `tests/Unit/BpjsEligibilityServiceTest.php`
  - **Estimated time:** 2 days

- [ ]* 90. Write Feature Tests for API Endpoints
  - Test patient CRUD endpoints
  - Test queue management endpoints
  - Test outpatient visit endpoints
  - Test lab order and result endpoints
  - Test prescription and dispensing endpoints
  - Test billing and payment endpoints
  - **Files to create:** `tests/Feature/PatientApiTest.php`, `tests/Feature/QueueApiTest.php`, `tests/Feature/OutpatientApiTest.php`, `tests/Feature/LaboratoryApiTest.php`, `tests/Feature/PharmacyApiTest.php`, `tests/Feature/BillingApiTest.php`
  - **Estimated time:** 3 days

- [ ]* 91. Write Integration Tests for External Services
  - Test BPJS VClaim integration with test credentials
  - Test SATUSEHAT submission with test environment
  - Test HL7 message parsing with sample messages
  - Test notification delivery (email, SMS)
  - **Files to create:** `tests/Integration/BpjsIntegrationTest.php`, `tests/Integration/SatuSehatIntegrationTest.php`, `tests/Integration/Hl7IntegrationTest.php`
  - **Estimated time:** 2 days

- [ ]* 92. Write Browser Tests for Critical Workflows
  - Test patient registration workflow end-to-end
  - Test outpatient visit with SOAP documentation
  - Test inpatient admission workflow
  - Test pharmacy dispensing workflow
  - Test billing and payment workflow
  - **Files to create:** `tests/Browser/PatientRegistrationTest.php`, `tests/Browser/OutpatientVisitTest.php`, `tests/Browser/InpatientAdmissionTest.php`, `tests/Browser/PharmacyDispensingTest.php`, `tests/Browser/BillingWorkflowTest.php`
  - **Estimated time:** 3 days

- [ ] 93. Checkpoint - Run Full Test Suite
  - Run all unit tests
  - Run all feature tests
  - Run all integration tests
  - Run all property-based tests
  - Run all browser tests
  - Verify code coverage meets minimum threshold (80%)
  - Ensure all tests pass, ask the user if questions arise.

### Phase 7: Deployment & Training

- [ ] 94. Create Deployment Scripts and Configuration
  - Create production environment configuration
  - Create database migration rollback procedures
  - Create deployment checklist
  - Configure production error tracking (Sentry)
  - Configure production monitoring (New Relic/DataDog)
  - Set up log aggregation (ELK/Splunk)
  - Configure SSL certificates
  - Set up load balancer configuration
  - **Files to create:** `deploy.sh`, `.env.production.example`, `DEPLOYMENT.md`
  - **Estimated time:** 2 days

- [ ] 95. Create User Training Materials
  - Create Patient Registration Guide (PDF/Video)
  - Create BPJS Verification Guide
  - Create SOAP Documentation Guide
  - Create Prescription Guide
  - Create Lab Order Guide
  - Create Inpatient Admission Guide
  - Create Billing & Payment Guide
  - Create reference cards with keyboard shortcuts and common codes
  - **Files to create:** Training materials in `docs/training/`
  - **Estimated time:** 3 days

- [ ] 96. Conduct User Acceptance Testing (UAT)
  - Prepare UAT test cases covering all modules
  - Recruit users from each department (registration, outpatient, lab, pharmacy, inpatient, billing)
  - Conduct UAT sessions with real-world scenarios
  - Collect feedback and prioritize fixes
  - Address critical issues before go-live
  - Document known issues and workarounds

- [ ] 97. Data Migration from Old System
  - Export patient data from existing system
  - Map old schema to new schema
  - Create data transformation scripts
  - Import patients with MR number preservation
  - Import historical visits and diagnoses
  - Import medication and allergy history
  - Import billing history
  - Verify data integrity after migration
  - **Files to create:** `database/migrations/data_migration.php`, `app/Console/Commands/MigrateOldData.php`
  - **Estimated time:** 5 days

- [ ] 98. Perform Production Deployment
  - Schedule maintenance window
  - Backup current production database
  - Deploy application code to production servers
  - Run database migrations
  - Run data migration scripts
  - Verify all services running correctly
  - Test critical workflows in production
  - Monitor error logs and performance metrics
  - Notify users of system availability

- [ ] 99. Post-Deployment Monitoring and Support
  - Monitor application performance and error rates
  - Monitor database query performance
  - Monitor queue processing
  - Monitor external integration success rates (BPJS, SATUSEHAT)
  - Provide on-site support during first week
  - Address user-reported issues promptly
  - Collect user feedback for future enhancements

- [ ] 100. Final Checkpoint - System Verification
  - Verify all modules functioning in production
  - Verify all external integrations working (BPJS, SATUSEHAT)
  - Verify real-time features working (queues, notifications, broadcasts)
  - Verify report generation working
  - Verify backup system running
  - Document lessons learned
  - Celebrate successful deployment! 🎉

---

## Notes

- **Tasks marked with `*` are optional** and can be skipped for faster MVP delivery, but are recommended for quality assurance
- **Property-based tests** are limited to features with mathematical or round-trip properties (MR numbers, FHIR serialization, HL7 parsing)
- **Each module checkpoint** ensures incremental validation before moving to the next phase
- **Dependencies**: Later tasks depend on earlier foundation tasks being completed first
- **Time estimates** are approximate and may vary based on team size and experience
- **Critical path**: Foundation → Patient Management → Clinical Modules → Billing → Deployment
- **Parallel work opportunities**: After foundation is complete, clinical modules can be developed in parallel by different team members

## Task Dependency Graph

```json
{
  "waves": [
    { "id": 0, "tasks": ["1"] },
    { "id": 1, "tasks": ["2", "10"] },
    { "id": 2, "tasks": ["3", "4", "5", "6", "7", "11", "12"] },
    { "id": 3, "tasks": ["8", "13", "14", "15"] },
    { "id": 4, "tasks": ["16", "17", "17.1", "25", "30"] },
    { "id": 5, "tasks": ["18", "26", "31", "31.1", "33", "33.1"] },
    { "id": 6, "tasks": ["19", "21", "27", "32"] },
    { "id": 7, "tasks": ["20", "22", "28", "29"] },
    { "id": 8, "tasks": ["23", "35"] },
    { "id": 9, "tasks": ["36", "37", "38", "40", "45", "52", "60", "64", "68", "74", "78"] },
    { "id": 10, "tasks": ["39", "39.1", "41", "46", "53", "61", "65", "69", "75", "79"] },
    { "id": 11, "tasks": ["42", "47", "54", "62", "66", "70", "76", "80"] },
    { "id": 12, "tasks": ["43", "48", "55", "63", "67", "71", "77", "77.1", "81"] },
    { "id": 13, "tasks": ["44", "44.1", "49", "56", "72", "82"] },
    { "id": 14, "tasks": ["50", "50.1", "57", "83", "84"] },
    { "id": 15, "tasks": ["58", "85", "86"] },
    { "id": 16, "tasks": ["59", "59.1", "87", "88"] },
    { "id": 17, "tasks": ["89", "90"] },
    { "id": 18, "tasks": ["91", "92"] },
    { "id": 19, "tasks": ["94", "95"] },
    { "id": 20, "tasks": ["97"] },
    { "id": 21, "tasks": ["98"] },
    { "id": 22, "tasks": ["99"] }
  ]
}
```
