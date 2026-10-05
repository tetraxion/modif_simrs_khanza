# Requirements Document: SIMRS Khanza Full System Refactoring

## Introduction

This document specifies the requirements for a complete refactoring of the existing Laravel-based Hospital Information Management System (SIMRS) to align with the workflow, structure, and functionality of SIMRS Khanza. The refactoring encompasses patient flow management, clinical documentation, pharmacy operations, laboratory and radiology services, billing systems, medical records management, and external integrations including BPJS and SATUSEHAT. The system must support concurrent multi-user access across all hospital departments while maintaining regulatory compliance with Indonesian healthcare standards (Kemenkes, BPJS, Hospital Accreditation).

## Glossary

- **System**: The SIMRS application including web interface, database, and integrations
- **Patient_Registration_Module**: Component handling new patient registration and medical record number generation
- **Queue_Management_Module**: Component managing patient queues across registration, outpatient, and pharmacy
- **Outpatient_Module**: Component managing ambulatory care visits including SOAP documentation
- **Inpatient_Module**: Component managing hospitalization including admission, monitoring, and discharge
- **Emergency_Module**: Component managing emergency department including triage and trauma scoring
- **Operating_Room_Module**: Component managing surgical procedures and scheduling
- **Pharmacy_Module**: Component managing medication inventory, dispensing, and drug interaction checking
- **Laboratory_Module**: Component managing lab orders, specimen tracking, and results
- **Radiology_Module**: Component managing imaging orders, DICOM integration, and radiologist reporting
- **Billing_Module**: Component calculating charges and managing payments
- **Medical_Record_Module**: Component storing and retrieving integrated electronic medical records
- **BPJS_Integration**: External integration with Indonesian national health insurance system
- **SATUSEHAT_Integration**: External integration with Ministry of Health data platform
- **Audit_Trail**: System logging all user activities for compliance and security
- **EMR**: Electronic Medical Record - integrated digital patient record
- **CPPT**: Catatan Perkembangan Pasien Terintegrasi (Integrated Patient Progress Notes)
- **SOAP**: Subjective, Objective, Assessment, Plan - clinical documentation format
- **ICD_10**: International Classification of Diseases version 10 - diagnosis coding system
- **ICD_9_CM**: International Classification of Diseases version 9 Clinical Modification - procedure coding system
- **SEP**: Surat Eligibilitas Peserta - BPJS eligibility letter
- **Triase**: Emergency department patient prioritization using color codes
- **MEOWS**: Modified Early Obstetric Warning Score
- **BOR**: Bed Occupancy Rate - hospital capacity metric
- **LOS**: Length of Stay - average hospitalization duration
- **LPLPO**: Laporan Pemakaian dan Lembar Permintaan Obat - pharmacy usage and request report
- **RL**: Rumah Sakit (Hospital) Reports - mandatory government reporting format

## Requirements

### Requirement 1: Patient Registration and Medical Record Number Generation

**User Story:** As a registration staff member, I want to register new patients with auto-generated medical record numbers, so that each patient has a unique identifier across all hospital visits.

#### Acceptance Criteria

1. WHEN a new patient registration is submitted, THE Patient_Registration_Module SHALL generate a unique medical record number following the hospital's numbering format
2. THE Patient_Registration_Module SHALL validate that NIK (national ID) is exactly 16 digits IF provided
3. THE Patient_Registration_Module SHALL validate that BPJS number is unique IF provided
4. THE Patient_Registration_Module SHALL store patient demographic data including name, gender, birth date, address, contact information, emergency contact, and insurance information
5. THE Patient_Registration_Module SHALL support patient photo upload with file size validation
6. WHEN duplicate NIK or BPJS number is detected, THE Patient_Registration_Module SHALL prevent registration and display existing patient information
7. FOR ALL patient registrations, generating a medical record number then saving then retrieving SHALL return the same medical record number (round-trip property)

### Requirement 2: Queue Management System

**User Story:** As a patient or staff member, I want an automated queue management system with real-time display, so that patient flow is organized and wait times are transparent.

#### Acceptance Criteria

1. WHEN a patient registers for outpatient service, THE Queue_Management_Module SHALL generate a queue number for the selected clinic
2. THE Queue_Management_Module SHALL maintain separate queues for registration counter, each outpatient clinic, and pharmacy
3. WHEN a queue number is called, THE Queue_Management_Module SHALL update the real-time display within 2 seconds
4. THE Queue_Management_Module SHALL support manual queue advancement by authorized staff
5. THE Queue_Management_Module SHALL generate printable queue tickets with QR code
6. WHEN operating hours end, THE Queue_Management_Module SHALL reset queue numbers for the next day
7. THE Queue_Management_Module SHALL track queue waiting time and service time metrics
8. WHERE display screens are installed, THE System SHALL show current queue numbers and waiting patients

### Requirement 3: BPJS Integration for Patient Verification

**User Story:** As a registration staff member, I want to verify BPJS patient eligibility through VClaim API, so that I can confirm insurance coverage before service delivery.

#### Acceptance Criteria

1. WHEN BPJS number is provided, THE BPJS_Integration SHALL query VClaim API for patient eligibility within 5 seconds
2. IF VClaim API returns patient not eligible, THEN THE System SHALL display eligibility status and reason
3. THE BPJS_Integration SHALL retrieve patient data including name, birth date, insurance class, and active status from VClaim
4. THE BPJS_Integration SHALL create SEP (eligibility letter) with diagnosis and treatment plan
5. WHEN SEP creation fails, THE System SHALL log error details and allow manual SEP entry
6. THE BPJS_Integration SHALL support SEP deletion and updating within the allowed timeframe
7. THE System SHALL store SEP number linked to the visit record

### Requirement 4: Outpatient Initial Medical Assessment

**User Story:** As a physician, I want to document initial medical assessment with specialty-specific templates, so that I can capture relevant clinical information efficiently.

#### Acceptance Criteria

1. THE Outpatient_Module SHALL provide assessment templates for each specialty including General Practice, Oral Surgery, Cardiology, Psychiatry, Pediatrics, Obstetrics, and Dentistry
2. WHEN a patient arrives at clinic, THE Outpatient_Module SHALL display patient demographics, insurance type, and previous visit history
3. THE Outpatient_Module SHALL capture vital signs including blood pressure, temperature, pulse, respiratory rate, height, and weight
4. THE Outpatient_Module SHALL support free-text entry for chief complaint, history of present illness, and physical examination findings
5. THE Outpatient_Module SHALL allow BMI calculation from height and weight measurements
6. WHEN vital signs are outside normal ranges, THE System SHALL display warning indicators
7. THE Outpatient_Module SHALL timestamp each assessment with physician identifier

### Requirement 5: SOAP Documentation with ICD Coding

**User Story:** As a physician, I want to document clinical encounters using SOAP format with ICD-10 diagnosis codes and ICD-9-CM procedure codes, so that medical records are standardized and billable.

#### Acceptance Criteria

1. THE Outpatient_Module SHALL provide SOAP documentation fields for Subjective, Objective, Assessment, and Plan
2. THE Outpatient_Module SHALL integrate ICD-10 diagnosis code search with autocomplete
3. THE Outpatient_Module SHALL support multiple diagnosis codes per visit with primary diagnosis designation
4. THE Outpatient_Module SHALL integrate ICD-9-CM procedure code search for procedures performed
5. THE Outpatient_Module SHALL validate that at least one diagnosis code is entered before saving
6. THE Outpatient_Module SHALL support procedure billing with quantity and pricing
7. WHEN SOAP documentation is completed, THE System SHALL update visit status to "Examined"
8. THE Outpatient_Module SHALL support copying previous visit SOAP notes as templates

### Requirement 6: Laboratory Order Management

**User Story:** As a physician, I want to order laboratory tests with predefined templates, so that I can quickly request common test panels based on clinical indication.

#### Acceptance Criteria

1. THE Laboratory_Module SHALL provide test templates grouped by clinical indication (e.g., Pre-operative, Diabetes, Lipid Panel, Kidney Function)
2. WHEN a lab order is created, THE Laboratory_Module SHALL generate a unique laboratory request number
3. THE Laboratory_Module SHALL support individual test selection and custom test panels
4. THE Laboratory_Module SHALL capture clinical indication and relevant patient history
5. THE Laboratory_Module SHALL generate barcode labels for specimen identification
6. WHEN lab order is saved, THE System SHALL send order to laboratory queue within 1 second
7. THE Laboratory_Module SHALL track specimen collection status and timestamp
8. WHERE specimen collection is delayed beyond 30 minutes, THE System SHALL alert laboratory staff

### Requirement 7: Laboratory Result Entry and Validation

**User Story:** As a laboratory analyst, I want to enter test results with automatic normal range flagging, so that abnormal values are highlighted for physician review.

#### Acceptance Criteria

1. THE Laboratory_Module SHALL display pending laboratory orders with patient information and requested tests
2. THE Laboratory_Module SHALL provide result entry fields with data type validation (numeric, text, dropdown)
3. WHEN a result value is outside normal range, THE Laboratory_Module SHALL flag the result as High or Low
4. THE Laboratory_Module SHALL support manual bridging from laboratory instruments
5. THE Laboratory_Module SHALL require analyst verification with digital signature before result publication
6. WHERE critical values are detected, THE System SHALL require immediate physician notification with acknowledgment
7. THE Laboratory_Module SHALL validate that all ordered tests have results before allowing finalization
8. WHEN results are finalized, THE System SHALL update visit status and notify ordering physician

### Requirement 8: Laboratory Result Reporting

**User Story:** As a physician or patient, I want to view and print laboratory results with graphical trends, so that I can interpret test results and monitor changes over time.

#### Acceptance Criteria

1. THE Laboratory_Module SHALL generate printable laboratory reports with hospital branding and QR code for verification
2. THE Laboratory_Module SHALL display result history with graphical trend lines for numeric values
3. THE Laboratory_Module SHALL support result delivery via email or WhatsApp where patient consent is obtained
4. THE Laboratory_Module SHALL show normal ranges and flag abnormal values in reports
5. THE Laboratory_Module SHALL require physician approval before results are released to patients
6. THE Laboratory_Module SHALL log all report views and prints in the Audit_Trail
7. THE System SHALL support exporting laboratory data to SATUSEHAT_Integration format

### Requirement 9: Radiology Order and Scheduling

**User Story:** As a physician, I want to order radiology examinations with clinical indication and scheduling, so that imaging studies are performed with appropriate protocols.

#### Acceptance Criteria

1. THE Radiology_Module SHALL provide examination selection from available modalities (X-Ray, CT, MRI, Ultrasound, Mammography)
2. WHEN a radiology order is created, THE Radiology_Module SHALL generate unique request number
3. THE Radiology_Module SHALL require clinical indication and relevant patient history
4. THE Radiology_Module SHALL support examination scheduling with date and time selection
5. THE Radiology_Module SHALL validate equipment availability before confirming schedule
6. THE Radiology_Module SHALL send examination orders to radiology queue in real-time
7. WHERE contrast media is required, THE System SHALL flag orders for technologist preparation

### Requirement 10: Radiology Result and DICOM Image Management

**User Story:** As a radiologist, I want to document imaging findings and upload DICOM images, so that complete radiology reports are available for referring physicians.

#### Acceptance Criteria

1. THE Radiology_Module SHALL provide examination-specific report templates for each imaging modality
2. THE Radiology_Module SHALL support DICOM image upload with file size up to 100MB per study
3. THE Radiology_Module SHALL support JPEG image upload as alternative to DICOM
4. THE Radiology_Module SHALL provide free-text fields for examination technique, findings, and impression
5. THE Radiology_Module SHALL support image viewer for DICOM files with zoom and window/level controls
6. WHEN radiology report is finalized, THE System SHALL require radiologist digital signature
7. THE Radiology_Module SHALL generate printable reports with selected representative images
8. WHERE PACS system is available, THE System SHALL integrate with PACS for image storage and retrieval

### Requirement 11: Prescription Management and Drug Interaction Checking

**User Story:** As a physician, I want to prescribe medications with automatic drug interaction checking, so that I can prevent adverse drug events.

#### Acceptance Criteria

1. THE Pharmacy_Module SHALL provide medication search with generic and brand name autocomplete
2. WHEN a medication is added to prescription, THE Pharmacy_Module SHALL check for drug-drug interactions with existing prescriptions
3. IF significant drug interaction is detected, THEN THE System SHALL display warning with severity level and clinical recommendation
4. THE Pharmacy_Module SHALL support prescription templates for common conditions
5. THE Pharmacy_Module SHALL validate dose, frequency, and route of administration
6. THE Pharmacy_Module SHALL calculate total medication quantity based on dose and duration
7. THE Pharmacy_Module SHALL support prescription printing with patient instructions and medication labels
8. WHEN prescription is saved, THE System SHALL send order to pharmacy queue within 1 second

### Requirement 12: Pharmacy Dispensing and Stock Management

**User Story:** As a pharmacist, I want to verify and dispense prescriptions with automatic stock deduction, so that medication inventory is accurately maintained.

#### Acceptance Criteria

1. THE Pharmacy_Module SHALL display pending prescriptions in pharmacy queue ordered by queue number
2. THE Pharmacy_Module SHALL show medication availability and stock levels during dispensing
3. WHEN prescription is verified by pharmacist, THE System SHALL require pharmacist digital signature
4. THE Pharmacy_Module SHALL automatically deduct dispensed quantities from inventory
5. IF medication stock is insufficient, THEN THE System SHALL suggest alternatives and notify prescribing physician
6. THE Pharmacy_Module SHALL generate medication labels with patient name, drug name, dose, frequency, and instructions
7. THE Pharmacy_Module SHALL require patient counseling documentation before dispensing completion
8. WHERE medication is high-alert drug, THE System SHALL require double-check verification by two pharmacists

### Requirement 13: Pharmacy Inventory Management

**User Story:** As a pharmacy manager, I want to manage medication inventory across multiple storage locations with expiration monitoring, so that stock availability is maintained and expired medications are identified.

#### Acceptance Criteria

1. THE Pharmacy_Module SHALL support multiple storage locations including Main Pharmacy, Inpatient Depot, and Emergency Depot
2. THE Pharmacy_Module SHALL track medication stock by batch number, expiration date, and purchase price
3. WHEN stock level falls below reorder point, THE System SHALL generate purchase requisition alert
4. THE Pharmacy_Module SHALL identify medications expiring within 90 days
5. THE Pharmacy_Module SHALL support stock transfers between locations with approval workflow
6. THE Pharmacy_Module SHALL perform FIFO (First In First Out) stock rotation automatically during dispensing
7. THE Pharmacy_Module SHALL generate LPLPO reports for government reporting
8. THE Pharmacy_Module SHALL analyze fast-moving and slow-moving medications monthly

### Requirement 14: Inpatient Admission and Bed Management

**User Story:** As a registration staff member, I want to admit patients to available beds with automatic bed status tracking, so that bed occupancy is accurately maintained.

#### Acceptance Criteria

1. THE Inpatient_Module SHALL display real-time bed availability by ward and room
2. WHEN a patient is admitted, THE Inpatient_Module SHALL assign bed and update bed status to "Occupied"
3. THE Inpatient_Module SHALL generate unique inpatient registration number
4. THE Inpatient_Module SHALL capture admission diagnosis, admitting physician, and admission notes
5. THE Inpatient_Module SHALL support bed transfer with transfer reason documentation
6. WHERE bed transfer occurs, THE System SHALL update bed status and maintain transfer history
7. THE Inpatient_Module SHALL calculate admission deposits based on insurance class and estimated length of stay
8. THE Inpatient_Module SHALL prevent double bed assignment with validation check

### Requirement 15: Inpatient Initial Assessment

**User Story:** As a physician or nurse, I want to complete initial medical and nursing assessments with condition-specific templates, so that baseline patient status is documented comprehensively.

#### Acceptance Criteria

1. THE Inpatient_Module SHALL provide initial medical assessment templates for General, Cardiac, Neonatal, and ICU admissions
2. THE Inpatient_Module SHALL provide initial nursing assessment templates for Adult, Infant, and Geriatric patients
3. THE Inpatient_Module SHALL include risk assessment tools for Fall Risk, MEOWS, Suicide Risk, and Pressure Ulcer Risk
4. THE Inpatient_Module SHALL calculate risk scores automatically from assessment inputs
5. WHEN high-risk score is identified, THE System SHALL generate care plan alerts
6. THE Inpatient_Module SHALL require assessment completion within 24 hours of admission
7. WHERE assessment is overdue, THE System SHALL escalate alert to department supervisor

### Requirement 16: CPPT (Integrated Patient Progress Notes)

**User Story:** As a healthcare provider, I want to document patient progress in integrated notes visible to all team members, so that care coordination is seamless.

#### Acceptance Criteria

1. THE Inpatient_Module SHALL provide CPPT documentation interface accessible to physicians, nurses, and allied health professionals
2. THE Inpatient_Module SHALL display CPPT entries in chronological order with timestamp and author identification
3. THE Inpatient_Module SHALL support SOAP format for physician progress notes
4. THE Inpatient_Module SHALL support nursing observation documentation by shift (morning, afternoon, night)
5. THE Inpatient_Module SHALL allow multiple CPPT entries per day per provider
6. THE Inpatient_Module SHALL support medication administration recording with time and signature
7. THE Inpatient_Module SHALL display patient's current active orders and care plans alongside CPPT
8. THE Inpatient_Module SHALL require authentication before viewing or editing CPPT entries

### Requirement 17: Vital Signs and Fluid Balance Monitoring

**User Story:** As a nurse, I want to record vital signs and fluid intake/output multiple times per day, so that patient monitoring data is tracked accurately.

#### Acceptance Criteria

1. THE Inpatient_Module SHALL support vital signs entry with timestamp for blood pressure, temperature, pulse, respiratory rate, and oxygen saturation
2. THE Inpatient_Module SHALL generate vital signs flowsheet with graphical trends
3. THE Inpatient_Module SHALL support fluid balance tracking with intake sources (oral, IV, blood products) and output sources (urine, drain, vomit)
4. THE Inpatient_Module SHALL calculate total intake, total output, and fluid balance automatically
5. WHEN vital signs are outside critical thresholds, THE System SHALL trigger alert to physician
6. THE Inpatient_Module SHALL support pain assessment recording using standardized pain scales
7. WHERE intensive care monitoring is required, THE System SHALL support hourly vital signs documentation

### Requirement 18: Pre-Operative and Post-Operative Checklists

**User Story:** As a surgical nurse, I want to complete standardized pre-operative and post-operative safety checklists, so that surgical safety protocols are followed.

#### Acceptance Criteria

1. THE Operating_Room_Module SHALL provide WHO Surgical Safety Checklist with three phases: Sign In, Time Out, and Sign Out
2. THE Operating_Room_Module SHALL require completion of pre-operative checklist before patient transfer to operating room
3. THE Operating_Room_Module SHALL validate that all checklist items are marked before proceeding to next phase
4. THE Operating_Room_Module SHALL capture team member signatures for each checklist phase
5. THE Operating_Room_Module SHALL provide post-operative checklist for recovery room transfer
6. IF checklist item indicates safety concern, THEN THE System SHALL prevent proceeding until concern is resolved
7. THE Operating_Room_Module SHALL include instrument count verification with discrepancy documentation

### Requirement 19: Operating Room Scheduling and Team Management

**User Story:** As a surgical coordinator, I want to schedule surgical procedures with team assignments, so that operating room utilization is optimized.

#### Acceptance Criteria

1. THE Operating_Room_Module SHALL display operating room availability calendar with time slots
2. WHEN scheduling surgery, THE Operating_Room_Module SHALL assign surgeon, anesthesiologist, assisting surgeons, and nursing staff
3. THE Operating_Room_Module SHALL validate that assigned staff are available during scheduled time
4. THE Operating_Room_Module SHALL support procedure duration estimation and room turnover time
5. THE Operating_Room_Module SHALL prevent double-booking of operating rooms
6. THE Operating_Room_Module SHALL support emergency case insertion with bump workflow
7. THE Operating_Room_Module SHALL generate daily operating room schedule reports for all staff
8. WHERE schedule changes occur, THE System SHALL notify affected team members in real-time

### Requirement 20: Surgical and Anesthesia Reporting

**User Story:** As a surgeon or anesthesiologist, I want to document operative findings and anesthesia management, so that surgical records are complete and accurate.

#### Acceptance Criteria

1. THE Operating_Room_Module SHALL provide operative report templates by surgical specialty
2. THE Operating_Room_Module SHALL capture pre-operative diagnosis, post-operative diagnosis, procedure performed, findings, and complications
3. THE Operating_Room_Module SHALL integrate ICD-9-CM procedure coding for billing
4. THE Operating_Room_Module SHALL provide anesthesia record with anesthetic agents, techniques, and monitoring data
5. THE Operating_Room_Module SHALL track surgical duration from incision to closure time
6. THE Operating_Room_Module SHALL support implant and prosthesis documentation with lot numbers
7. THE Operating_Room_Module SHALL require surgeon and anesthesiologist digital signatures
8. WHEN operative report is finalized, THE System SHALL make report available to inpatient care team within 5 minutes

### Requirement 21: Emergency Department Triage

**User Story:** As an emergency nurse, I want to perform triage assessment with color-coded priority levels, so that patients are treated according to clinical urgency.

#### Acceptance Criteria

1. THE Emergency_Module SHALL provide triage assessment form with chief complaint, vital signs, and primary survey
2. THE Emergency_Module SHALL assign triage level using color codes: Red (Immediate), Yellow (Urgent), Green (Non-Urgent), Black (Deceased)
3. THE Emergency_Module SHALL calculate trauma scores (GCS, RTS) automatically from assessment inputs
4. WHEN Red level patient is triaged, THE System SHALL trigger immediate physician notification
5. THE Emergency_Module SHALL display active emergency patients ordered by triage priority
6. THE Emergency_Module SHALL track time from triage to physician evaluation
7. WHERE re-triage is performed, THE System SHALL maintain triage history with timestamps
8. THE Emergency_Module SHALL generate daily emergency department census reports

### Requirement 22: Emergency Department Patient Tracking

**User Story:** As an emergency physician, I want to track patient location and status within emergency department, so that patient flow is visible to all team members.

#### Acceptance Criteria

1. THE Emergency_Module SHALL track patient status: Triage, Examination, Laboratory, Radiology, Observation, Discharge, Admission
2. THE Emergency_Module SHALL display emergency department patient board with real-time status updates
3. THE Emergency_Module SHALL support location assignment to examination rooms, observation beds, or procedure areas
4. THE Emergency_Module SHALL track disposition: Discharge Home, Admit to Inpatient, Transfer to Other Facility, Left Against Medical Advice, Deceased
5. WHEN patient status changes, THE System SHALL broadcast update to emergency department displays within 2 seconds
6. THE Emergency_Module SHALL calculate emergency department length of stay from arrival to disposition
7. THE Emergency_Module SHALL alert charge nurse when patients exceed target time thresholds

### Requirement 23: Inpatient Discharge Process

**User Story:** As a physician, I want to complete discharge documentation with medical resume and patient education, so that discharge is safe and comprehensive.

#### Acceptance Criteria

1. THE Inpatient_Module SHALL provide discharge summary template with admission diagnosis, hospital course, discharge diagnosis, procedures performed, and discharge medications
2. THE Inpatient_Module SHALL require completion of discharge medications with prescriptions
3. THE Inpatient_Module SHALL document discharge instructions and patient education provided
4. THE Inpatient_Module SHALL specify discharge disposition: Home, Home with Home Care, Transfer to Skilled Nursing, Transfer to Another Hospital, Deceased
5. THE Inpatient_Module SHALL generate follow-up appointment schedule and control letter
6. WHEN discharge documentation is finalized, THE System SHALL update bed status to "Available" within 1 minute
7. THE Inpatient_Module SHALL calculate final length of stay and trigger billing finalization
8. THE Inpatient_Module SHALL require patient or family signature for discharge acknowledgment

### Requirement 24: Billing Calculation and Invoice Generation

**User Story:** As a billing staff member, I want the system to automatically calculate all charges from services rendered, so that invoices are accurate and complete.

#### Acceptance Criteria

1. THE Billing_Module SHALL aggregate charges from consultations, procedures, medications, laboratory tests, radiology examinations, room charges, and nursing care
2. THE Billing_Module SHALL apply pricing based on patient insurance class (General, BPJS Class 1/2/3, Private Insurance)
3. THE Billing_Module SHALL calculate daily room charges from admission date to discharge date
4. THE Billing_Module SHALL support discounts with discount reason documentation
5. THE Billing_Module SHALL support payment deposit deduction from total charges
6. THE Billing_Module SHALL round total charges according to hospital policy
7. THE Billing_Module SHALL generate detailed invoice with itemized charges by category
8. WHERE BPJS insurance is used, THE System SHALL separate billable and non-billable items per BPJS formulary

### Requirement 25: Payment Processing and Receipt

**User Story:** As a cashier, I want to process payments with multiple payment methods, so that patient transactions are completed efficiently.

#### Acceptance Criteria

1. THE Billing_Module SHALL support payment methods including Cash, Debit Card, Credit Card, Bank Transfer, and Mixed Payment
2. WHEN payment is received, THE Billing_Module SHALL generate official receipt with receipt number and hospital stamp
3. THE Billing_Module SHALL support partial payments with remaining balance tracking
4. THE Billing_Module SHALL validate that payment amount matches invoice total or document reason for difference
5. THE Billing_Module SHALL support payment cancellation with supervisor approval and documentation
6. THE Billing_Module SHALL update patient account status from "Outstanding" to "Paid" upon full payment
7. THE Billing_Module SHALL generate daily cashier closing report with cash reconciliation
8. THE Billing_Module SHALL support receipt reprinting with audit trail logging

### Requirement 26: Integrated Electronic Medical Record

**User Story:** As a healthcare provider, I want to view complete patient medical history across all encounters, so that clinical decisions are informed by comprehensive information.

#### Acceptance Criteria

1. THE Medical_Record_Module SHALL display patient EMR in chronological timeline view
2. THE Medical_Record_Module SHALL integrate data from outpatient visits, inpatient admissions, emergency visits, laboratory results, radiology reports, and medication history
3. THE Medical_Record_Module SHALL provide filtered views by encounter type, date range, diagnosis, or provider
4. THE Medical_Record_Module SHALL support document scanning and upload with categorization
5. THE Medical_Record_Module SHALL display active problems, allergies, and current medications prominently
6. THE Medical_Record_Module SHALL support clinical summary generation for referrals and continuity of care
7. THE Medical_Record_Module SHALL enforce role-based access control with audit trail logging
8. WHERE sensitive information exists, THE System SHALL require additional authentication for access

### Requirement 27: Medical Record Coding and Reporting

**User Story:** As a medical record coder, I want to review and code encounters with ICD-10 and ICD-9-CM, so that hospital statistics and claims are accurate.

#### Acceptance Criteria

1. THE Medical_Record_Module SHALL provide coding interface with discharge summaries and operative reports
2. THE Medical_Record_Module SHALL support multiple ICD-10 diagnosis codes with principal diagnosis designation
3. THE Medical_Record_Module SHALL support ICD-9-CM procedure coding for surgical and non-surgical procedures
4. THE Medical_Record_Module SHALL validate code format and existence in current code set
5. THE Medical_Record_Module SHALL generate RL (Hospital Report) 1-6 for government submission
6. THE Medical_Record_Module SHALL generate top 10 disease reports by frequency
7. THE Medical_Record_Module SHALL generate top 10 procedure reports by frequency
8. THE Medical_Record_Module SHALL calculate hospital statistics including BOR, LOS, TOI, BTO, and GDR

### Requirement 28: BPJS Claim Submission

**User Story:** As a BPJS claim officer, I want to submit inpatient and outpatient claims electronically, so that hospital reimbursement is processed efficiently.

#### Acceptance Criteria

1. THE BPJS_Integration SHALL generate claim files in VClaim-compatible format
2. THE BPJS_Integration SHALL validate that SEP exists for each claim
3. THE BPJS_Integration SHALL group claim data including patient demographics, diagnoses, procedures, medications, and charges
4. THE BPJS_Integration SHALL submit claims to BPJS via VClaim API
5. WHEN claim submission fails, THE System SHALL log error details and allow claim correction
6. THE BPJS_Integration SHALL track claim status: Submitted, Accepted, Rejected, Paid
7. THE BPJS_Integration SHALL retrieve claim verification results from BPJS
8. WHERE claim is rejected, THE System SHALL display rejection reason and allow resubmission

### Requirement 29: SATUSEHAT Integration for National Health Data

**User Story:** As a hospital administrator, I want to submit patient encounter data to SATUSEHAT platform, so that the hospital complies with Ministry of Health reporting requirements.

#### Acceptance Criteria

1. THE SATUSEHAT_Integration SHALL map EMR data to FHIR (Fast Healthcare Interoperability Resources) format
2. THE SATUSEHAT_Integration SHALL submit patient demographics, encounter details, diagnoses, procedures, and medication data
3. THE SATUSEHAT_Integration SHALL authenticate using hospital credentials issued by Ministry of Health
4. WHEN SATUSEHAT submission succeeds, THE System SHALL store submission confirmation ID
5. IF SATUSEHAT submission fails, THEN THE System SHALL queue data for retry with exponential backoff
6. THE SATUSEHAT_Integration SHALL submit data daily at scheduled time during off-peak hours
7. THE SATUSEHAT_Integration SHALL generate submission status reports for monitoring
8. THE System SHALL support manual retry for failed submissions with error details

### Requirement 30: Staff Management and Scheduling

**User Story:** As a human resources manager, I want to manage staff profiles and schedules, so that workforce allocation is optimized.

#### Acceptance Criteria

1. THE System SHALL maintain staff registry including physicians, nurses, pharmacists, laboratory technicians, radiographers, and administrative staff
2. THE System SHALL store staff credentials including licenses, certifications, and expiration dates
3. WHEN credential expiration is within 30 days, THE System SHALL alert staff and supervisor
4. THE System SHALL support shift scheduling with shift templates (morning, afternoon, night, 24-hour)
5. THE System SHALL validate that staff are not double-scheduled during the same time period
6. THE System SHALL integrate with biometric attendance devices for clock-in/clock-out
7. THE System SHALL calculate working hours, overtime, and leave balances
8. WHERE on-call schedules are defined, THE System SHALL display current on-call staff by department

### Requirement 31: Asset and Equipment Management

**User Story:** As a biomedical engineer, I want to track medical equipment with maintenance schedules, so that equipment is properly maintained and calibrated.

#### Acceptance Criteria

1. THE System SHALL maintain asset registry with equipment ID, name, model, serial number, purchase date, and location
2. THE System SHALL track maintenance history including preventive maintenance and repair records
3. THE System SHALL schedule preventive maintenance based on manufacturer recommendations or hospital policy
4. WHEN maintenance is due within 7 days, THE System SHALL alert biomedical engineering staff
5. THE System SHALL track calibration due dates for equipment requiring periodic calibration
6. THE System SHALL support equipment status tracking: Available, In Use, Under Maintenance, Retired
7. THE System SHALL calculate depreciation for financial reporting
8. WHERE equipment failure occurs, THE System SHALL support incident reporting and downtime tracking

### Requirement 32: Audit Trail and User Activity Logging

**User Story:** As a security officer, I want comprehensive logging of all user activities, so that security incidents can be investigated and regulatory compliance is maintained.

#### Acceptance Criteria

1. THE Audit_Trail SHALL log all user logins with timestamp, username, IP address, and device information
2. THE Audit_Trail SHALL log all data access including patient record views, modifications, and deletions
3. THE Audit_Trail SHALL log all clinical actions including order entry, result entry, and medication administration
4. THE Audit_Trail SHALL log all financial transactions including billing and payment processing
5. THE Audit_Trail SHALL store logs in tamper-proof format with integrity verification
6. THE Audit_Trail SHALL support log search and filtering by user, action type, patient, and date range
7. THE Audit_Trail SHALL generate user activity reports for compliance audits
8. THE Audit_Trail SHALL retain logs for minimum 7 years per regulatory requirements

### Requirement 33: System Configuration and Customization

**User Story:** As a system administrator, I want to configure hospital-specific settings and templates, so that the system aligns with hospital policies and workflows.

#### Acceptance Criteria

1. THE System SHALL provide configuration interface for hospital information including name, address, logo, and contact details
2. THE System SHALL support customization of medical record number format and numbering sequence
3. THE System SHALL support configuration of room and bed naming conventions
4. THE System SHALL support customization of form templates for assessments, reports, and letters
5. THE System SHALL support pricing configuration for all chargeable items with effective dates
6. THE System SHALL support configuration of normal ranges for laboratory tests by age and gender
7. THE System SHALL support configuration of user roles and permissions with granular access control
8. WHERE configuration changes affect billing, THE System SHALL require supervisor approval and audit logging

### Requirement 34: Database Backup and Recovery

**User Story:** As a system administrator, I want automated database backups with recovery capability, so that data loss is prevented in case of system failure.

#### Acceptance Criteria

1. THE System SHALL perform automated full database backup daily during off-peak hours
2. THE System SHALL perform incremental backups every 6 hours during operational hours
3. THE System SHALL validate backup integrity after completion
4. WHEN backup fails, THE System SHALL retry up to 3 times and alert administrator if all attempts fail
5. THE System SHALL retain daily backups for 30 days and monthly backups for 1 year
6. THE System SHALL support point-in-time recovery using transaction logs
7. THE System SHALL document backup restore procedures with regular restore testing
8. THE System SHALL store backups in redundant locations including off-site storage

### Requirement 35: Performance Optimization for High Concurrency

**User Story:** As a hospital administrator, I want the system to handle 500 concurrent users with acceptable response time, so that operations are not disrupted during peak hours.

#### Acceptance Criteria

1. THE System SHALL support minimum 500 concurrent user sessions
2. THE System SHALL respond to user actions within 2 seconds for 95% of requests under normal load
3. THE System SHALL implement database query optimization with proper indexing
4. THE System SHALL implement caching for frequently accessed reference data
5. THE System SHALL implement connection pooling for database connections
6. WHEN system load exceeds 80% capacity, THE System SHALL alert administrators
7. THE System SHALL implement graceful degradation when resource limits are reached
8. THE System SHALL support horizontal scaling with load balancing for future growth

### Requirement 36: Notification System

**User Story:** As a healthcare provider, I want to receive real-time notifications for critical events, so that I can respond promptly to patient needs.

#### Acceptance Criteria

1. THE System SHALL send notifications for critical laboratory results within 1 minute of result entry
2. THE System SHALL send notifications for STAT orders to relevant departments within 30 seconds
3. THE System SHALL send medication administration reminders to nurses based on scheduled times
4. THE System SHALL send notifications for overdue documentation to responsible providers
5. THE System SHALL support notification delivery via in-app alerts, email, and SMS
6. THE System SHALL allow users to configure notification preferences by event type
7. THE System SHALL maintain notification history with acknowledgment status
8. WHERE notification requires acknowledgment, THE System SHALL escalate if not acknowledged within defined timeframe

### Requirement 37: Report Generation System

**User Story:** As a department manager, I want to generate operational and statistical reports, so that performance metrics are monitored and decisions are data-driven.

#### Acceptance Criteria

1. THE System SHALL provide pre-defined report templates for daily census, admission/discharge statistics, and revenue reports
2. THE System SHALL support custom report generation with parameter selection for date range, department, and provider
3. THE System SHALL export reports in PDF, Excel, and CSV formats
4. THE System SHALL generate graphical visualizations including bar charts, line graphs, and pie charts
5. THE System SHALL schedule automatic report generation and email delivery
6. THE System SHALL provide dashboard with key performance indicators refreshed in real-time
7. THE System SHALL support drill-down from summary reports to detailed transaction data
8. THE System SHALL calculate financial metrics including revenue by service type, payer mix, and provider productivity

### Requirement 38: Medication Formulary Management

**User Story:** As a pharmacy and therapeutics committee member, I want to manage hospital formulary with BPJS and non-formulary designations, so that medication use is controlled and cost-effective.

#### Acceptance Criteria

1. THE Pharmacy_Module SHALL maintain medication formulary with formulary status (Formulary, Non-Formulary, Restricted)
2. THE Pharmacy_Module SHALL designate medications as BPJS-covered or non-covered based on National Formulary
3. WHERE non-formulary medication is prescribed, THE System SHALL alert prescriber and suggest formulary alternatives
4. THE Pharmacy_Module SHALL enforce restrictions requiring approval for restricted medications
5. THE Pharmacy_Module SHALL track formulary compliance rates by department and provider
6. THE Pharmacy_Module SHALL support medication therapeutic interchange protocols
7. THE Pharmacy_Module SHALL maintain medication monographs with indication, dosing, contraindications, and interactions
8. THE System SHALL update BPJS formulary status when national formulary changes are published

### Requirement 39: Infection Control Monitoring

**User Story:** As an infection control nurse, I want to track healthcare-associated infections, so that infection prevention measures can be implemented.

#### Acceptance Criteria

1. THE System SHALL flag patients with confirmed or suspected infections requiring isolation precautions
2. THE System SHALL support documentation of isolation type (Contact, Droplet, Airborne, Protective)
3. WHEN isolation precaution is ordered, THE System SHALL display visible alerts on patient banner
4. THE System SHALL track healthcare-associated infection cases with infection site, organism, and onset date
5. THE System SHALL generate infection surveillance reports by unit, organism, and infection type
6. THE System SHALL calculate infection rates per 1000 patient days
7. THE System SHALL alert infection control team when infection clusters are detected
8. WHERE multidrug-resistant organisms are identified, THE System SHALL trigger enhanced surveillance protocols

### Requirement 40: Clinical Decision Support

**User Story:** As a physician, I want clinical decision support alerts for evidence-based care, so that care quality and safety are improved.

#### Acceptance Criteria

1. THE System SHALL check for medication allergies before prescription is finalized
2. IF patient has documented allergy to prescribed medication, THEN THE System SHALL block prescription and require override justification
3. THE System SHALL provide dosing guidance for weight-based and renal-adjusted medications
4. THE System SHALL alert for duplicate therapy when medications from the same therapeutic class are prescribed
5. THE System SHALL provide evidence-based order sets for common conditions (Pneumonia, Heart Failure, Sepsis)
6. THE System SHALL alert for missing preventive care (VTE prophylaxis, Fall prevention, Pressure ulcer prevention)
7. THE System SHALL support customizable alert rules by hospital clinical practice guidelines
8. WHERE alert is overridden, THE System SHALL require documented justification and track override rates

---

## Document Metadata

- **Version**: 1.0
- **Date**: 2026-09-15
- **Total Requirements**: 40
- **Requirement Categories**:
  - Patient Registration & Queue Management: 3 requirements
  - Outpatient Care: 2 requirements
  - Laboratory Services: 3 requirements
  - Radiology Services: 2 requirements
  - Pharmacy Services: 4 requirements
  - Inpatient Care: 4 requirements
  - Operating Room: 3 requirements
  - Emergency Department: 2 requirements
  - Billing & Finance: 2 requirements
  - Medical Records: 2 requirements
  - External Integrations: 2 requirements
  - System Administration: 6 requirements
  - Clinical Quality & Safety: 2 requirements
  - Cross-cutting: 3 requirements

