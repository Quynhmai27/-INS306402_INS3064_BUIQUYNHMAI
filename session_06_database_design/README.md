# Session 06 – Database Design

---

## Part 1: Normalization

### Original Table
Hospital_Appointments_Raw

Columns:  
PatientID, PatientName, DoctorName, DoctorSpecialization, AppointmentDate, TreatmentDescription, TreatmentCost

Example Data:

| PatientID | PatientName | DoctorName | DoctorSpecialization | AppointmentDate | TreatmentDescription | TreatmentCost |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| 1 | Nguyen An | Dr. Le | Cardiology | 2024-03-10 | Heart Checkup | 200 |
| 1 | Nguyen An | Dr. Le | Cardiology | 2024-03-10 | ECG Test | 150 |
| 2 | Tran Binh | Dr. Tran | Neurology | 2024-03-11 | Brain MRI | 500 |

---

## Task 1: Identify Violations

### Redundant Columns

The following columns cause redundancy because they repeat across multiple rows:

- PatientName  
- DoctorName  
- DoctorSpecialization  

For example, if a patient has multiple treatments during one appointment, the same **patient information** and **doctor information** will be repeated in several rows.

Similarly, **doctor specialization** is repeated every time the same doctor appears in the table.

---

### Update Anomalies

1. **Doctor Specialization Change**  
If a doctor changes their specialization, every row containing that doctor must be updated.

2. **Patient Name Update**  
If a patient changes their name or details, all rows containing that patient must also be updated.

These situations create a risk of inconsistent or outdated data.

---

### Transitive Dependencies

The table contains several transitive dependencies:

PatientID → PatientName  

DoctorName → DoctorSpecialization  

AppointmentDate depends on PatientID and DoctorName  

DoctorName → DoctorSpecialization  

Because some non-key attributes depend on other non-key attributes, the table does not satisfy **Third Normal Form (3NF)**.

---

## Task 2: Decompose to 3NF

To remove redundancy and anomalies, the table can be decomposed into the following normalized tables.

| Table | Primary Key | Foreign Key(s) | Non-key columns |
| :--- | :--- | :--- | :--- |
| Patients | patient_id | None | name, date_of_birth, phone |
| Doctors | doctor_id | None | name, specialization |
| Appointments | appointment_id | patient_id, doctor_id | appointment_date, status |
| Treatments | treatment_id | appointment_id | description, cost |

---

## Explanation

**Patients**  
Stores patient information such as name and contact details. Separating this table avoids repeating patient information across multiple records.

**Doctors**  
Stores doctor information including their specialization.

**Appointments**  
Represents the relationship between patients and doctors. Each appointment connects one patient with one doctor at a specific time.

**Treatments**  
Stores treatment details for each appointment. One appointment can include multiple treatments.

---

## Part 2: Relationships

### 1. Patients — Appointments

Relationship Type: One-to-Many (1:N)

FK Location: appointments.patient_id

Explanation: One patient can have many appointments, but each appointment belongs to only one patient.

---

### 2. Doctors — Appointments

Relationship Type: One-to-Many (1:N)

FK Location: appointments.doctor_id

Explanation: One doctor can handle many appointments, but each appointment is assigned to one doctor.

---

### 3. Appointments — Treatments

Relationship Type: One-to-Many (1:N)

FK Location: treatments.appointment_id

Explanation: One appointment can include multiple treatments, but each treatment belongs to only one appointment.

---

### 4. Doctors — Patients

Relationship Type: Many-to-Many (N:N) through Appointments

FK Location: appointments.patient_id, appointments.doctor_id

Explanation: A doctor can treat many patients, and a patient can visit many doctors.  
This relationship is handled through the **appointments** table.