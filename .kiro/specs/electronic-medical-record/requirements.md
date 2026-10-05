# Requirements Document: Electronic Medical Record (EMR)

## Introduction

This document specifies the requirements for a comprehensive Electronic Medical Record (EMR) system for SIMRS (Hospital Management Information System). The EMR system will centralize medical documentation, assessments, and patient care records across outpatient and inpatient settings, following clinical standards and best practices from SIMRS Khanza.

The system integrates with existing SIMRS modules (patient registration, outpatient care, inpatient care, laboratory, radiology, pharmacy, and billing) to provide a unified view of patient medical history and current status.

## Glossary

- **EMR_System**: The Electronic Medical Record module that manages all medical documentation and assessments
- **Medical_Assessment**: Initial medical evaluation performed by physicians for outpatient or inpatient care
- **Nursing_Assessment**: Initial nursing evaluation and care planning performed by nurses
- **Specialized_Assessment**: Targeted assessment for specific patient conditions (suicide risk, violence behavior, newborn, etc.)
- **SOAP_Note**: Structured clinical note format containing Subjective, Objective, Assessment, and Plan sections
- **Vital_Signs**: Measured physiological parameters including blood pressure, pulse, temperature, respiratory rate, SpO2, height, weight, and BMI
- **Medical_Timeline**: Chronological sequence of all medical events for a patient
- **ICD_10**: International Classification of Diseases, 10th Revision for diagnosis coding
- **ICD_9_CM**: International Classification of Diseases, 9th Revision, Clinical Modification for procedure coding
- **Digital_Signature**: Electronic signature verification for medical documents
- **Audit_Trail**: Historical record of who accessed or modified medical records and when
- **Template_Engine**: System for creating reusable medical record templates per specialty
- **Medical_Calculator**: Built-in tools for calculating BMI, GCS, and other clinical scores
- **Drug_Interaction_Checker**: System that validates medication combinations for safety
- **Access_Log**: Record of who accessed sensitive patient medical data
- **Validation_Status**: Indicator of whether medical record documentation is complete
- **Copy_Forward**: Feature to copy previous visit data into new medical record entry
- **Resume_Medis**: Medical summary document for discharge or transfer
- **Konsultasi_Medik**: Medical consultation request and response between physicians
- **Edukasi_Pasien**: Patient and family education documentation
- **Checklist_Klinis**: Clinical checklists for procedures and criteria (ICU admission, pre-op, post-op, etc.)
- **Penilaian_Khusus**: Specialized clinical assessments for specific patient populations or conditions
- **MEOWS**: Modified Early Obstetric Warning System score for obstetric patients
- **GCS**: Glasgow Coma Scale for neurological assessment
- **Pain_Scale**: Numerical or categorical pain assessment score
- **Fall_Risk_Score**: Assessment score for patient fall risk
- **Nutritional_Status**: Patient nutritional assessment and status
- **Nursing_Diagnosis**: NANDA-approved nursing diagnosis for care planning
- **Supportive_Document**: Scanned or uploaded medical documents attached to patient record
- **Clinical_Notification**: Alert system for incomplete records or clinical events
- **Role_Based_Access**: Permission system that controls EMR access based on user role
- **Patient_Protection**: Security measures to track and audit access to sensitive patient data

## Requirements

### Requirement 1: Medical Assessment Management

**User Story:** As a physician, I want to create and manage initial medical assessments for outpatient and inpatient encounters, so that I can document comprehensive patient evaluations according to clinical standards.

#### Acceptance Criteria

1. WHEN a physician selects a patient encounter, THE EMR_System SHALL display the appropriate medical assessment form based on encounter type (outpatient general, oral surgery, cardiology, emergency psychiatry, inpatient cardiology, neonatal)
2. THE Medical_Assessment SHALL include SOAP_Note sections (Subjective, Objective, Assessment, Plan) with structured input fields
3. THE Medical_Assessment SHALL capture Vital_Signs including blood pressure, pulse rate, temperature, respiratory rate, SpO2, height, weight, and automatically calculate BMI
4. THE Medical_Assessment SHALL include fields for chief complaint, present illness history, past medical history, family history, social history, and allergy documentation
5. THE Medical_Assessment SHALL provide systematic physical examination sections organized by body system
6. WHEN a physician saves a Medical_Assessment, THE EMR_System SHALL record the digital signature, timestamp, and physician identifier
7. THE Medical_Assessment SHALL support preliminary diagnosis entry with ICD_10 code search and selection
8. WHEN a physician requests Copy_Forward, THE EMR_System SHALL populate relevant fields from the patient's most recent Medical_Assessment
9. THE Medical_Assessment SHALL validate required fields before allowing submission
10. FOR ALL saved Medical_Assessment records, THE EMR_System SHALL generate an Audit_Trail entry

### Requirement 2: Nursing Assessment Management

**User Story:** As a nurse, I want to create and manage nursing assessments for outpatient and inpatient care, so that I can document comprehensive nursing evaluations and develop appropriate care plans.

#### Acceptance Criteria

1. WHEN a nurse selects a patient encounter, THE EMR_System SHALL display the appropriate nursing assessment form based on encounter type (outpatient, inpatient adult, inpatient infant, geriatric)
2. THE Nursing_Assessment SHALL include primary and secondary nursing surveys with structured assessment fields
3. THE Nursing_Assessment SHALL capture Pain_Scale assessment using numerical or categorical scales
4. THE Nursing_Assessment SHALL calculate and document Fall_Risk_Score based on standard risk assessment tools
5. THE Nursing_Assessment SHALL assess and document Nutritional_Status including dietary intake and restrictions
6. THE Nursing_Assessment SHALL support Nursing_Diagnosis selection from standardized NANDA taxonomy
7. WHEN a nurse saves a Nursing_Assessment, THE EMR_System SHALL record the digital signature, timestamp, and nurse identifier
8. THE Nursing_Assessment SHALL include care planning sections with nursing interventions and expected outcomes
9. THE Nursing_Assessment SHALL validate required fields before allowing submission
10. FOR ALL saved Nursing_Assessment records, THE EMR_System SHALL generate an Audit_Trail entry

### Requirement 3: Specialized Assessment Management

**User Story:** As a healthcare provider, I want to perform specialized clinical assessments for specific patient conditions, so that I can identify risks and implement appropriate interventions.

#### Acceptance Criteria

1. THE EMR_System SHALL provide Penilaian_Khusus forms for newborn assessment, suicide risk, violence behavior risk, elopement risk, abuse victim assessment, terminal patient assessment, immunocompromised patient assessment, poisoning assessment, infectious disease assessment, MEOWS, pediatric anxiety assessment, pre-anesthesia assessment, and psychological assessment
2. WHEN a provider selects a Penilaian_Khusus type, THE EMR_System SHALL display the appropriate assessment form with condition-specific fields
3. THE Penilaian_Khusus SHALL calculate risk scores automatically based on entered assessment data
4. WHEN a risk score exceeds defined thresholds, THE EMR_System SHALL generate a Clinical_Notification for appropriate staff
5. THE Penilaian_Khusus SHALL support multi-disciplinary documentation where multiple providers contribute to the assessment
6. WHEN a provider saves a Penilaian_Khusus, THE EMR_System SHALL record the digital signature, timestamp, and provider identifier
7. THE Penilaian_Khusus SHALL integrate with existing patient data to pre-populate relevant fields
8. THE EMR_System SHALL track completion status for required specialized assessments based on patient condition
9. FOR ALL saved Penilaian_Khusus records, THE EMR_System SHALL generate an Audit_Trail entry

### Requirement 4: Diagnostic Test Results Integration

**User Story:** As a physician, I want to view and document results from diagnostic tests within the medical record, so that I can integrate clinical findings into patient assessment and care planning.

#### Acceptance Criteria

1. THE EMR_System SHALL integrate ultrasound examination results with structured reporting fields
2. THE EMR_System SHALL integrate echocardiography examination results with cardiac measurement fields
3. THE EMR_System SHALL integrate treadmill test results with exercise parameters and findings
4. THE EMR_System SHALL display laboratory results from the existing pemeriksaan_labs table within the patient's Medical_Timeline
5. THE EMR_System SHALL display radiology results from the existing pemeriksaan_radiologis table within the patient's Medical_Timeline
6. WHEN new diagnostic results are available, THE EMR_System SHALL generate a Clinical_Notification for the ordering physician
7. THE EMR_System SHALL allow physicians to add clinical interpretation notes to diagnostic results
8. THE EMR_System SHALL support comparison viewing of serial diagnostic results over time
9. THE EMR_System SHALL link diagnostic results to relevant Medical_Assessment entries

### Requirement 5: Clinical Checklist Management

**User Story:** As a clinical staff member, I want to use standardized checklists for critical procedures and transitions of care, so that I can ensure all required steps are completed and documented.

#### Acceptance Criteria

1. THE EMR_System SHALL provide Checklist_Klinis forms for ICU/HCU/Isolation admission criteria, ICU/HCU/Isolation discharge criteria, pre-operative checklist, post-operative checklist, fibrinolytic administration checklist, and ESWL procedure documentation
2. WHEN a staff member accesses a Checklist_Klinis, THE EMR_System SHALL display all checklist items with checkboxes and timestamp fields
3. THE Checklist_Klinis SHALL require verification signatures from appropriate staff members before marking as complete
4. THE Checklist_Klinis SHALL validate that all required items are checked before allowing submission
5. WHEN a critical checklist item is not completed, THE EMR_System SHALL generate a Clinical_Notification
6. THE Checklist_Klinis SHALL capture free-text notes for items requiring additional explanation
7. THE EMR_System SHALL track completion time for each checklist item
8. FOR ALL completed Checklist_Klinis records, THE EMR_System SHALL generate an Audit_Trail entry

### Requirement 6: Patient Education and Consultation Documentation

**User Story:** As a healthcare provider, I want to document patient education and medical consultations, so that I can track care coordination and patient understanding of their condition and treatment.

#### Acceptance Criteria

1. THE EMR_System SHALL provide Edukasi_Pasien forms for outpatient and inpatient settings with structured education topics
2. THE Edukasi_Pasien SHALL document education content delivered, education method used, patient understanding assessment, and family member participation
3. THE Edukasi_Pasien SHALL require signatures from both educator and patient/family member
4. THE EMR_System SHALL provide Konsultasi_Medik forms for inter-physician consultation requests and responses
5. THE Konsultasi_Medik SHALL capture requesting physician, consulting physician, consultation reason, clinical question, and consultation response
6. WHEN a Konsultasi_Medik is requested, THE EMR_System SHALL generate a Clinical_Notification for the consulting physician
7. THE Konsultasi_Medik SHALL track response time from request to consultation completion
8. THE EMR_System SHALL support nursing consultation requests between nursing staff
9. FOR ALL education and consultation records, THE EMR_System SHALL generate an Audit_Trail entry

### Requirement 7: Medical Summary and Discharge Documentation

**User Story:** As a physician, I want to create comprehensive medical summaries and discharge documentation, so that I can provide complete care records for patient transitions and continuity of care.

#### Acceptance Criteria

1. THE EMR_System SHALL provide Resume_Medis forms for inpatient discharge and outpatient episode closure
2. THE Resume_Medis SHALL automatically populate patient demographics, admission/visit dates, primary and secondary diagnoses, procedures performed, medications prescribed, and key clinical findings from linked medical records
3. THE Resume_Medis SHALL include fields for hospital course summary, discharge condition, discharge instructions, follow-up recommendations, and physician summary
4. THE Resume_Medis SHALL support ICD_10 code assignment for all diagnoses and ICD_9_CM code assignment for all procedures
5. THE EMR_System SHALL provide Multi-Professional Partnership evaluation forms for interdisciplinary team assessment
6. THE EMR_System SHALL provide forms for documenting patient leave of absence requests during inpatient care
7. THE EMR_System SHALL provide forms for documenting patient refusal of recommended medical treatment
8. WHEN a Resume_Medis is finalized, THE EMR_System SHALL lock the document from further editing and require digital signature
9. THE Resume_Medis SHALL be exportable to PDF format with official hospital letterhead
10. FOR ALL finalized Resume_Medis records, THE EMR_System SHALL generate an Audit_Trail entry

### Requirement 8: Integrated Medical Timeline View

**User Story:** As a healthcare provider, I want to view a chronological timeline of all medical events for a patient, so that I can quickly understand the patient's complete medical history and current status.

#### Acceptance Criteria

1. WHEN a provider accesses a patient record, THE EMR_System SHALL display a Medical_Timeline showing all medical events in reverse chronological order
2. THE Medical_Timeline SHALL include all Medical_Assessment entries, Nursing_Assessment entries, Penilaian_Khusus entries, diagnostic test results, medications from reseps table, procedures, Checklist_Klinis completions, Edukasi_Pasien records, and Konsultasi_Medik records
3. THE Medical_Timeline SHALL display each event with timestamp, event type, provider name, and summary information
4. THE Medical_Timeline SHALL support filtering by event type, date range, provider, and facility location
5. WHEN a provider clicks on a timeline event, THE EMR_System SHALL display the complete event details
6. THE Medical_Timeline SHALL visually distinguish between outpatient and inpatient encounters
7. THE Medical_Timeline SHALL integrate billing information from the billing table showing payment status per encounter
8. THE Medical_Timeline SHALL support keyword search across all medical record text fields
9. THE Medical_Timeline SHALL be exportable to PDF format showing all events within a selected date range

### Requirement 9: Historical Medical Data Access

**User Story:** As a healthcare provider, I want to access comprehensive historical medical data for a patient, so that I can review patterns and trends to inform current clinical decisions.

#### Acceptance Criteria

1. THE EMR_System SHALL provide a visit history view showing all outpatient visits from rawat_jalans table and inpatient stays from rawat_inaps table
2. THE EMR_System SHALL provide a diagnosis history view showing all ICD_10 coded diagnoses across all encounters with date and encounter type
3. THE EMR_System SHALL provide a procedure history view showing all ICD_9_CM coded procedures across all encounters with date and encounter type
4. THE EMR_System SHALL provide a medication history view showing all medications from reseps and resep_details tables with dates, dosages, and prescribing physician
5. THE EMR_System SHALL provide a laboratory results history showing all results from pemeriksaan_labs table with trend graphs for numeric values
6. THE EMR_System SHALL provide a radiology results history showing all imaging studies from pemeriksaan_radiologis table with reports
7. THE EMR_System SHALL provide a billing history showing all charges and payments from billing table
8. THE EMR_System SHALL support date range filtering for all historical views
9. THE EMR_System SHALL support comparison of similar data points across different time periods
10. THE EMR_System SHALL highlight abnormal values in laboratory results based on reference ranges

### Requirement 10: Medical Record Search and Retrieval

**User Story:** As a medical records staff member, I want to search and retrieve patient medical records using multiple criteria, so that I can efficiently locate records for clinical care, reporting, and administrative purposes.

#### Acceptance Criteria

1. THE EMR_System SHALL support search by patient name, medical record number (no_rm), national ID (nik), insurance number (no_bpjs), and date of birth
2. THE EMR_System SHALL support search by diagnosis using ICD_10 code or diagnosis text
3. THE EMR_System SHALL support search by procedure using ICD_9_CM code or procedure text
4. THE EMR_System SHALL support search by physician name or physician identifier
5. THE EMR_System SHALL support search by date range for encounters or specific medical events
6. THE EMR_System SHALL support combined search criteria using AND logic
7. WHEN search results exceed 100 records, THE EMR_System SHALL implement pagination
8. THE EMR_System SHALL display search results in a sortable table showing patient name, no_rm, last encounter date, and primary diagnosis
9. THE EMR_System SHALL allow direct navigation from search results to patient Medical_Timeline
10. THE EMR_System SHALL log all search activities in Access_Log for security auditing

### Requirement 11: Medical Record Export and Printing

**User Story:** As a healthcare provider, I want to export and print medical records in standardized formats, so that I can share patient information for referrals, legal purposes, and patient requests.

#### Acceptance Criteria

1. THE EMR_System SHALL export individual Medical_Assessment forms to PDF format with hospital branding and official formatting
2. THE EMR_System SHALL export Resume_Medis documents to PDF format with digital signature verification display
3. THE EMR_System SHALL export complete Medical_Timeline to PDF format including all events within selected date range
4. THE EMR_System SHALL export Checklist_Klinis to PDF format showing completion status and signatures
5. THE EMR_System SHALL export laboratory results to PDF format with graphs for trended values
6. THE EMR_System SHALL export medication lists to PDF format showing current and historical medications
7. WHEN a medical record is exported, THE EMR_System SHALL include export timestamp and exporting user information in the document footer
8. THE EMR_System SHALL support batch export of multiple patient records for authorized users
9. THE EMR_System SHALL generate an Audit_Trail entry for all export activities
10. THE EMR_System SHALL watermark exported documents with "CONFIDENTIAL MEDICAL RECORD" text

### Requirement 12: Document Scanning and Upload

**User Story:** As a medical records staff member, I want to scan and upload external medical documents to patient records, so that I can maintain complete patient documentation including records from outside facilities.

#### Acceptance Criteria

1. THE EMR_System SHALL support upload of Supportive_Document files in PDF, JPEG, PNG, and TIFF formats
2. THE EMR_System SHALL validate uploaded file size not exceeding 10MB per file
3. WHEN uploading a Supportive_Document, THE EMR_System SHALL require document type classification (external lab result, external imaging, referral letter, consent form, insurance documentation, other)
4. THE EMR_System SHALL require document date and optional description fields for each uploaded document
5. THE EMR_System SHALL link uploaded documents to specific patient encounters when applicable
6. THE EMR_System SHALL display uploaded documents within the patient's Medical_Timeline
7. THE EMR_System SHALL support document preview without downloading
8. THE EMR_System SHALL generate an Audit_Trail entry recording who uploaded each document and when
9. THE EMR_System SHALL support document deletion only by authorized roles with reason documentation
10. WHEN a document is deleted, THE EMR_System SHALL retain a record in Audit_Trail but remove access to the file

### Requirement 13: Digital Signature for Medical Documents

**User Story:** As a physician or nurse, I want to digitally sign medical documents, so that I can authenticate my documentation and comply with legal requirements for medical record signatures.

#### Acceptance Criteria

1. THE EMR_System SHALL require Digital_Signature for all finalized Medical_Assessment documents
2. THE EMR_System SHALL require Digital_Signature for all finalized Nursing_Assessment documents
3. THE EMR_System SHALL require Digital_Signature for all finalized Resume_Medis documents
4. THE EMR_System SHALL require Digital_Signature for all completed Checklist_Klinis documents
5. WHEN a user applies a Digital_Signature, THE EMR_System SHALL capture the user's credentials, timestamp, and IP address
6. THE EMR_System SHALL validate the signing user has appropriate credentials for the document type being signed
7. WHEN a document has a Digital_Signature, THE EMR_System SHALL lock the document from further editing
8. THE EMR_System SHALL display Digital_Signature information including signer name, credentials, and timestamp on all signed documents
9. THE EMR_System SHALL support verification of Digital_Signature authenticity
10. FOR ALL Digital_Signature events, THE EMR_System SHALL generate an Audit_Trail entry

### Requirement 14: Role-Based Access Control for EMR

**User Story:** As a system administrator, I want to configure role-based access controls for medical records, so that I can ensure users only access medical information appropriate to their role and responsibilities.

#### Acceptance Criteria

1. THE EMR_System SHALL grant physicians (dokter role) permission to create, view, and edit Medical_Assessment records and view all other medical records
2. THE EMR_System SHALL grant nurses (perawat role) permission to create, view, and edit Nursing_Assessment records and view all other medical records
3. THE EMR_System SHALL grant administrators (admin role) permission to view all medical records but not create or edit clinical documentation
4. THE EMR_System SHALL grant medical records staff (new rekam_medis role) permission to view, search, export, and upload documents but not create clinical assessments
5. THE EMR_System SHALL grant pharmacists (farmasi role) permission to view medication-related sections of medical records
6. THE EMR_System SHALL grant laboratory staff (laboratorium role) permission to view laboratory-related sections and enter laboratory results
7. THE EMR_System SHALL grant radiology staff (radiologi role) permission to view radiology-related sections and enter radiology results
8. THE EMR_System SHALL deny access to medical records for users with kasir role except for encounter verification purposes
9. WHEN a user attempts to access a function without appropriate permissions, THE EMR_System SHALL display an access denied message
10. THE EMR_System SHALL log all access attempts in Access_Log including successful and denied access

### Requirement 15: Audit Trail for Medical Records

**User Story:** As a compliance officer, I want to review audit trails for medical record access and modifications, so that I can ensure accountability and investigate potential security or quality issues.

#### Acceptance Criteria

1. THE EMR_System SHALL record an Audit_Trail entry for every medical record creation with user, timestamp, and record type
2. THE EMR_System SHALL record an Audit_Trail entry for every medical record modification with user, timestamp, fields changed, and previous values
3. THE EMR_System SHALL record an Audit_Trail entry for every medical record view with user, timestamp, and patient identifier
4. THE EMR_System SHALL record an Audit_Trail entry for every medical record export with user, timestamp, patient identifier, and export format
5. THE EMR_System SHALL record an Audit_Trail entry for every Digital_Signature application
6. THE EMR_System SHALL provide an audit trail search interface filtering by user, patient, date range, and action type
7. THE EMR_System SHALL display audit trail results showing timestamp, user, action, patient, and record type in a sortable table
8. THE EMR_System SHALL support audit trail export to CSV format for external analysis
9. THE EMR_System SHALL retain audit trail records for minimum 7 years regardless of patient record status
10. THE EMR_System SHALL restrict audit trail viewing to users with admin or rekam_medis roles

### Requirement 16: Medical Record Validation and Completeness Checking

**User Story:** As a medical records staff member, I want to validate medical record completeness, so that I can ensure all required documentation is present before record finalization.

#### Acceptance Criteria

1. THE EMR_System SHALL define Validation_Status rules for required documentation based on encounter type (outpatient general, surgical, ICU admission, etc.)
2. WHEN an encounter is created, THE EMR_System SHALL initialize a Validation_Status checklist with required documentation items
3. THE EMR_System SHALL automatically update Validation_Status when required documents are created and signed
4. THE EMR_System SHALL display incomplete documentation items in a prominent notification on the patient record
5. THE EMR_System SHALL calculate a completeness percentage for each encounter based on Validation_Status
6. WHEN an encounter reaches 48 hours past encounter end time with incomplete documentation, THE EMR_System SHALL generate a Clinical_Notification to the responsible provider
7. THE EMR_System SHALL provide a facility-wide dashboard showing documentation completeness statistics by provider and department
8. THE EMR_System SHALL allow medical records staff to manually mark documentation as complete with reason documentation for exceptional cases
9. THE EMR_System SHALL prevent encounter billing finalization when Validation_Status shows incomplete required documentation
10. FOR ALL Validation_Status changes, THE EMR_System SHALL generate an Audit_Trail entry

### Requirement 17: Clinical Templates for Medical Documentation

**User Story:** As a physician or nurse, I want to use customizable templates for common medical documentation scenarios, so that I can efficiently document patient care while maintaining quality and consistency.

#### Acceptance Criteria

1. THE EMR_System SHALL provide a Template_Engine supporting creation of custom Medical_Assessment templates
2. THE Template_Engine SHALL allow administrators to create templates specific to poliklinik specialties from the polikliniks table
3. THE Template_Engine SHALL support template fields including free text, structured selections, numeric values, and calculated fields
4. WHEN a provider selects a template, THE EMR_System SHALL pre-populate the Medical_Assessment form with template structure and default values
5. THE Template_Engine SHALL support template versioning with effective date tracking
6. THE Template_Engine SHALL allow providers to save frequently used documentation as personal templates
7. THE Template_Engine SHALL support template sharing between providers within the same specialty
8. THE EMR_System SHALL track template usage statistics for quality improvement purposes
9. THE Template_Engine SHALL validate that templates comply with required documentation standards
10. THE EMR_System SHALL allow templates to include automatic insertion of recent Vital_Signs and laboratory values

### Requirement 18: Copy Forward from Previous Visits

**User Story:** As a physician, I want to copy relevant information from previous visits into new medical documentation, so that I can efficiently document ongoing care for chronic conditions while updating changed information.

#### Acceptance Criteria

1. WHEN creating a new Medical_Assessment, THE EMR_System SHALL display a Copy_Forward option showing the most recent 5 encounters
2. WHEN a physician selects Copy_Forward, THE EMR_System SHALL copy chronic medical history, medication list, allergy list, and relevant physical examination findings from the selected encounter
3. THE Copy_Forward SHALL clearly mark copied content with "COPIED FROM [encounter date]" indicators
4. THE Copy_Forward SHALL require the physician to update Vital_Signs with new measurements
5. THE Copy_Forward SHALL require the physician to document current chief complaint and changes since last visit
6. THE Copy_Forward SHALL not copy acute diagnoses or time-sensitive clinical information
7. WHEN Copy_Forward is used, THE EMR_System SHALL record the source encounter in Audit_Trail
8. THE EMR_System SHALL support selective Copy_Forward allowing physicians to choose specific sections to copy
9. THE Copy_Forward SHALL maintain formatting and structure from the source document
10. THE Copy_Forward SHALL be available only when the previous encounter is finalized and signed

### Requirement 19: ICD-10 and ICD-9-CM Code Selection

**User Story:** As a physician, I want to search and select standardized diagnosis and procedure codes, so that I can accurately code medical conditions and procedures for clinical and billing purposes.

#### Acceptance Criteria

1. THE EMR_System SHALL provide an ICD_10 code picker with search by code or description
2. THE ICD_10 picker SHALL support partial text matching and display results ranked by relevance and usage frequency
3. THE ICD_10 picker SHALL display code, full description, and clinical notes for each search result
4. THE EMR_System SHALL support multi-diagnosis selection with primary diagnosis designation
5. THE EMR_System SHALL provide an ICD_9_CM code picker with search by code or description for procedure coding
6. THE ICD_9_CM picker SHALL support partial text matching and display results ranked by relevance
7. THE EMR_System SHALL store ICD_10 codes with Medical_Assessment records and Resume_Medis documents
8. THE EMR_System SHALL store ICD_9_CM codes with procedure documentation in medical records
9. THE EMR_System SHALL maintain a facility-specific favorites list of frequently used codes per specialty
10. WHEN a code is selected, THE EMR_System SHALL display the code in both human-readable and billing formats

### Requirement 20: Drug Interaction Checking

**User Story:** As a physician, I want to receive alerts about potential drug interactions when prescribing medications, so that I can avoid harmful medication combinations and ensure patient safety.

#### Acceptance Criteria

1. WHEN a physician adds a medication to a prescription in the EMR_System, THE Drug_Interaction_Checker SHALL analyze the medication against the patient's current medication list from reseps table
2. WHEN a potential drug interaction is detected, THE Drug_Interaction_Checker SHALL display an alert showing the interacting medications, interaction severity, clinical effects, and recommendations
3. THE Drug_Interaction_Checker SHALL categorize interactions as severe (contraindicated), moderate (use with caution), or minor (monitor)
4. THE Drug_Interaction_Checker SHALL check for duplicate therapy (same medication or same drug class)
5. THE Drug_Interaction_Checker SHALL check for allergy conflicts using the patient's documented allergy list
6. THE Drug_Interaction_Checker SHALL allow physicians to override interaction warnings with required reason documentation
7. WHEN an interaction warning is overridden, THE EMR_System SHALL generate an Audit_Trail entry
8. THE Drug_Interaction_Checker SHALL be integrated into the Medical_Assessment medication ordering workflow
9. THE Drug_Interaction_Checker SHALL check interactions across all active medications regardless of prescribing physician
10. THE Drug_Interaction_Checker SHALL update its interaction database monthly with new drug interaction data

### Requirement 21: Clinical Calculators and Scoring Tools

**User Story:** As a healthcare provider, I want to use integrated medical calculators and scoring tools, so that I can quickly calculate clinical scores and make evidence-based decisions.

#### Acceptance Criteria

1. THE EMR_System SHALL provide a Medical_Calculator for Body Mass Index (BMI) that automatically calculates from entered height and weight
2. THE Medical_Calculator SHALL provide Glasgow Coma Scale (GCS) scoring with component selection and automatic total calculation
3. THE Medical_Calculator SHALL provide pediatric growth percentile calculations based on age, gender, height, and weight
4. THE Medical_Calculator SHALL provide estimated Glomerular Filtration Rate (eGFR) calculation from serum creatinine, age, and gender
5. THE Medical_Calculator SHALL provide APGAR score calculation for newborn assessments
6. THE Medical_Calculator SHALL provide Wells score for DVT and PE risk assessment
7. THE Medical_Calculator SHALL provide CURB-65 score for pneumonia severity assessment
8. THE Medical_Calculator SHALL automatically populate calculation inputs from existing patient data when available
9. WHEN a Medical_Calculator result is generated, THE EMR_System SHALL offer to insert the result directly into the current medical documentation
10. THE Medical_Calculator results SHALL be stored in medical records with timestamp and calculation inputs for reference

### Requirement 22: Clinical Notification System

**User Story:** As a healthcare provider, I want to receive notifications about important clinical events and incomplete documentation, so that I can respond promptly to patient care needs and administrative requirements.

#### Acceptance Criteria

1. WHEN a Konsultasi_Medik is requested, THE EMR_System SHALL generate a Clinical_Notification for the consulting physician
2. WHEN new diagnostic results are available, THE EMR_System SHALL generate a Clinical_Notification for the ordering physician
3. WHEN a medical record remains incomplete 24 hours after encounter, THE EMR_System SHALL generate a Clinical_Notification for the responsible provider
4. WHEN a specialized assessment risk score exceeds critical thresholds, THE EMR_System SHALL generate a Clinical_Notification for appropriate clinical staff
5. WHEN a critical Checklist_Klinis item is left incomplete, THE EMR_System SHALL generate a Clinical_Notification for the responsible staff
6. THE Clinical_Notification SHALL be displayed in a notification panel within the EMR_System interface
7. THE Clinical_Notification SHALL include timestamp, priority level, patient identifier, and notification type
8. THE EMR_System SHALL support marking notifications as read and filtering by priority and type
9. THE Clinical_Notification SHALL persist until acknowledged by the recipient
10. THE EMR_System SHALL send email notifications for critical alerts when provider is not actively logged in

### Requirement 23: Medical Record Locking and Amendment

**User Story:** As a medical records staff member, I want to manage medical record locking and amendments, so that I can maintain record integrity while allowing correction of errors according to legal standards.

#### Acceptance Criteria

1. WHEN a medical document receives a Digital_Signature, THE EMR_System SHALL lock the document preventing further editing
2. THE EMR_System SHALL provide an amendment function for locked documents requiring reason documentation
3. WHEN an amendment is requested, THE EMR_System SHALL create an addendum record linked to the original document
4. THE EMR_System SHALL display amendments inline with original content marked with "AMENDED [date]" notation
5. THE EMR_System SHALL preserve original content when amendments are made
6. THE EMR_System SHALL require supervisory approval for amendments to documents older than 30 days
7. THE EMR_System SHALL restrict amendment function to users with rekam_medis or admin roles
8. WHEN an amendment is made, THE EMR_System SHALL generate an Audit_Trail entry with original and amended content
9. THE EMR_System SHALL display amendment history showing all changes, authors, and timestamps
10. THE EMR_System SHALL include all amendments when exporting medical records to PDF

### Requirement 24: Medical Record Parser for Data Import

**User Story:** As a system administrator, I want to import medical records from external systems, so that I can consolidate patient data when interfacing with other healthcare facilities or migrating from legacy systems.

#### Acceptance Criteria

1. THE EMR_System SHALL provide a Medical_Record_Parser for HL7 v2.x formatted messages
2. THE Medical_Record_Parser SHALL parse patient demographics, diagnoses, procedures, medications, and laboratory results from HL7 messages
3. THE Medical_Record_Parser SHALL validate parsed data against EMR_System data format requirements
4. WHEN parsing fails validation, THE Medical_Record_Parser SHALL return descriptive error messages indicating which fields failed and why
5. THE EMR_System SHALL provide a Medical_Record_Pretty_Printer that formats imported data into structured medical record format
6. THE Medical_Record_Pretty_Printer SHALL generate human-readable output matching existing EMR_System document templates
7. FOR ALL valid parsed medical records, THE Medical_Record_Parser SHALL create corresponding EMR_System records linked to the correct patient by no_rm matching
8. THE EMR_System SHALL provide a round-trip verification function that parses imported data, prints it, then parses again to verify data integrity
9. THE Medical_Record_Parser SHALL log all import activities with source system, record count, success count, and error details
10. THE EMR_System SHALL quarantine imported records that cannot be automatically matched to existing patients for manual review

### Requirement 25: Patient Access to Medical Records

**User Story:** As a patient, I want to request and view my medical records through a secure portal, so that I can access my health information for personal use or sharing with other providers.

#### Acceptance Criteria

1. THE EMR_System SHALL provide a patient portal interface where patients can request access to their medical records
2. WHEN a patient requests medical records, THE EMR_System SHALL require identity verification using nik and date of birth
3. THE EMR_System SHALL display patient-appropriate medical record summaries excluding confidential provider notes
4. THE EMR_System SHALL allow patients to view visit history, diagnoses, medications, laboratory results, and radiology results
5. THE EMR_System SHALL allow patients to download their medical records in PDF format
6. THE EMR_System SHALL log all patient access to medical records in Access_Log
7. THE EMR_System SHALL allow patients to request official printed medical records requiring pickup with identification
8. WHEN a patient requests official records, THE EMR_System SHALL generate a Clinical_Notification for medical records staff
9. THE EMR_System SHALL track medical record release requests including purpose, date requested, date fulfilled, and recipient
10. THE EMR_System SHALL charge and record fees for medical record copies according to facility policy

## Quality Standards Applied

All requirements in this document follow:
- **EARS patterns** for structured requirement statements
- **INCOSE quality rules** for clarity, testability, and completeness
- **Active voice** with specific system names from the Glossary
- **Measurable criteria** with explicit conditions
- **Solution-free** focus on what the system must do, not how to implement it

## Round-Trip Testing Requirements

### Critical Parser Components
The Medical_Record_Parser (Requirement 24) implements data import/export functionality and requires comprehensive testing:

1. HL7 message parsing MUST be tested with round-trip property: parse → print → parse SHALL produce equivalent data
2. Medical record data export to external formats MUST be tested with round-trip property verification
3. Template serialization MUST be tested to ensure Template_Engine saves and loads templates without data loss

## Next Steps

Upon approval of these requirements, the workflow will proceed to:
1. Design phase: Create technical design document specifying architecture, database schema, and component interactions
2. Task creation: Break down implementation into concrete development tasks
3. Implementation: Execute tasks with property-based testing per acceptance criteria
