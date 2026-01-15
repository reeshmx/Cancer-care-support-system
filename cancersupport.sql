-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2026 at 01:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cancersupport`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartID` int(11) NOT NULL,
  `user_NIC` varchar(20) NOT NULL,
  `drugID` int(11) NOT NULL,
  `createdAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartID`, `user_NIC`, `drugID`, `createdAt`) VALUES
(21, '123', 1, '2025-07-06 13:20:52'),
(41, '2000123456', 1, '2025-11-05 20:50:46');

-- --------------------------------------------------------

--
-- Table structure for table `consult_appointment`
--

CREATE TABLE `consult_appointment` (
  `CON_APP_ID` int(11) NOT NULL,
  `PatientName` varchar(100) NOT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `PhoneNo` varchar(15) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Doctor_ID` int(11) DEFAULT NULL,
  `Doctor_Name` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `NIC` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consult_appointment`
--

INSERT INTO `consult_appointment` (`CON_APP_ID`, `PatientName`, `Age`, `Gender`, `PhoneNo`, `Address`, `Description`, `Doctor_ID`, `Doctor_Name`, `status`, `NIC`) VALUES
(16, 'Reeshma', 22, 'Female', '0757398232', '34, Kandy', 'Heart disease', 8, 'Abraham Hash', 1, '200380'),
(17, 'Reeshma', 22, 'Female', '0757398232', '34, Kandy', 'Heart can', 9, 'Dr. John  Doe', 5, '200380'),
(20, 'Reeshma', 22, 'Female', '0757398232', '34, Kandy', 'Lung cancer', 9, 'Dr. John  Doe', 1, '200380'),
(21, 'Reeshma', 22, 'Female', '0757398232', '34, Kandy', 'Cancer', 8, 'Abraham Hash', 1, '200380'),
(22, 'Sam', 30, 'Male', '0757398237', '34, Colombo', 'Lung cancer', 9, 'Dr. John  Doe', 1, '8000'),
(23, 'Sam', 30, 'Male', '0757398237', '34, Colombo', 'Lung disease', 9, 'Dr. John  Doe', 1, '2000'),
(24, 'Reeshma', 22, 'Female', '0757398232', '34, Kandy', 'Lung problem', 9, 'Dr. John  Doe', 1, '200380'),
(26, 'Sam', 30, 'Male', '0757398237', '34, Colombo', 'Lung cancer', 9, 'Dr. John  Doe', 5, '8000'),
(27, 'Jane', 25, 'Female', '0757398232', '34, Colombo', 'Lung cancer checkup', 10, 'Dr. Jane  Smith', 1, '1000'),
(28, 'Jane', 25, 'Female', '0757398232', '34, Colombo', 'Cancer', 10, 'Dr. Jane  Smith', 5, '1000'),
(29, 'Jane', 25, 'Female', '0757398232', '34, Colombo', 'Cancer checkup', 10, 'Dr. Jane  Smith', 1, '1000'),
(30, 'Camy', 35, 'Male', '0757398232', '34, Colombo', 'Blood cancer need medicine', 11, 'Dr. Robert  Brown', 1, '8000'),
(31, 'Jam', 40, 'Female', '0757398232', '56/Geliyoya', 'Breast cancer', 9, 'Dr. John  Doe', 1, '8001'),
(32, 'Jam', 40, 'Female', '0757398232', '56/Geliyoya', 'Cancer', 9, 'Dr. John  Doe', 0, '8001'),
(33, 'Camy', 35, 'Male', '0757398230', '6A/Galagedara', 'Lung cancer issues', 9, 'Dr. John  Doe', 0, '8000'),
(34, 'Camy', 35, 'Male', '07838747625', '6A/ Galagedara', 'Cancer related to lung', 9, 'Dr. John  Doe', 0, '8000'),
(35, 'Camy', 35, 'Male', '07838747625', '6A/ Galagedara', 'Lung cancer', 9, 'Dr. John  Doe', 0, '8000');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_consultation_response`
--

CREATE TABLE `doctor_consultation_response` (
  `Con_Doc_Res_ID` int(11) NOT NULL,
  `Doctor_Name` varchar(100) NOT NULL,
  `Doctor_NIC` varchar(20) NOT NULL,
  `PatientName` varchar(100) NOT NULL,
  `ConsultedDate` date NOT NULL,
  `ContactStatus` varchar(20) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `DoctorCharge` decimal(10,2) DEFAULT NULL,
  `MedicationList` text DEFAULT NULL,
  `MedicationTotalAmount` decimal(10,2) DEFAULT NULL,
  `CON_APP_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_consultation_response`
--

INSERT INTO `doctor_consultation_response` (`Con_Doc_Res_ID`, `Doctor_Name`, `Doctor_NIC`, `PatientName`, `ConsultedDate`, `ContactStatus`, `Description`, `DoctorCharge`, `MedicationList`, `MedicationTotalAmount`, `CON_APP_ID`) VALUES
(33, 'Hash', '2005', 'Reeshma', '2025-10-20', 'yes', 'Take this medicine two times a day', 3500.00, '[\"Doxorubicin\"]', 250.00, 16),
(34, 'Hash', '2005', 'Reeshma', '2025-10-22', 'no', 'Contact once again', 300.00, '[\"Pembrolizumab\",\"Pembrolizumab\"]', 1000.00, 21),
(35, 'Doe', '2000', 'Reeshma', '2025-10-22', 'yes', 'Contact again if needed', 500.00, '[\"Doxorubicin\"]', 250.00, 20),
(36, 'Doe', '2000', 'Sam', '2025-11-05', 'yes', 'Take these medicines Day and Night in a regular basis', 3000.00, '[\"Cisplatin\",\"Doxorubicin\",\"Trastuzumab\"]', 800.00, 22),
(37, 'Doe', '2000', 'Sam', '2025-11-05', 'yes', 'Lung cancer', 2000.00, '[\"Cisplatin\",\"Cisplatin\"]', 300.00, 23),
(38, 'Doe', '2000', 'Reeshma', '2025-11-05', 'yes', 'Take 3 times a day', 2000.00, '[\"Doxorubicin\",\"Imatinib\"]', 600.00, 24),
(40, 'Smith', '2001', 'Jane', '2025-11-06', 'yes', 'Take medicine properly', 2500.00, '[\"Doxorubicin\",\"Trastuzumab\"]', 650.00, 27),
(41, 'Smith', '2001', 'Jane', '2025-11-06', 'yes', 'Take regularly', 2500.00, '[\"Imatinib\"]', 350.00, 29),
(42, 'Brown', '2002', 'Camy', '2025-11-07', 'yes', 'Have them regularly', 3000.00, '[\"Tamoxifen\",\"Pembrolizumab\"]', 600.00, 30),
(43, 'Doe', '2000', 'Jam', '2025-11-07', 'yes', 'Take medicine', 2500.00, '[\"Cisplatin\",\"Imatinib\"]', 500.00, 31);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_details`
--

CREATE TABLE `doctor_details` (
  `Doctor_ID` int(11) NOT NULL,
  `Doctor_Name` varchar(100) NOT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `PhoneNo` varchar(15) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `NIC` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Specification` varchar(100) DEFAULT NULL,
  `Qualification` varchar(150) DEFAULT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `Self_Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_details`
--

INSERT INTO `doctor_details` (`Doctor_ID`, `Doctor_Name`, `Age`, `Gender`, `PhoneNo`, `Address`, `NIC`, `Email`, `DOB`, `Specification`, `Qualification`, `Photo`, `Self_Description`) VALUES
(8, 'Abraham Hash', 56, 'Male', '0778097658', 'Kandy', '2005', 'abraham@123', '1969-06-19', 'Pediatric Oncology', 'MBBS/MD/DM', '../img/DoctorImage/Abraham.jpg', 'A doctor who is specialized in treating children with cancer'),
(9, 'Dr. John  Doe', 45, 'Male', '1234567890', '123 Main St, Springfield', '2000', 'Johndoe@gamil.com', '1978-03-15', 'Oncology', 'MD, PhD', '../img/DoctorImage/johndoe.jpg', 'Experienced oncologist specializing in lung and breast cancer treatment.'),
(10, 'Dr. Jane  Smith', 38, 'Female', '0987654321', '56 Elm St, Shelbyville', '2001', 'janesmith@gmail.com', '1985-03-06', 'Oncology', 'MD, MS', '../img/DoctorImage/testimonial-1.jpg', 'Radiologist with over 10 years of experience in advanced diagnostic imaging.'),
(11, 'Dr. Robert  Brown', 30, 'Male', '3468929221', '56, Kandy', '2002', 'robertbrown@gmail.com', '1995-09-09', 'Hematology', 'MD, MBBS', '../img/DoctorImage/Doc.jpg', 'A hematologist is a specialist doctor who diagnoses and treats conditions related to the blood, bone marrow, and lymphatic system. .'),
(12, 'Dr. Emily  Johnson', 42, 'Female', '0773829234', '321 Pine St, Smalltown', '2003', 'emilyjohnson@gmail.com', '1981-04-04', 'Hematology', 'MD, PhD', '../img/DoctorImage/emily.jpg', 'Hematologist with a focus on blood cancers, including leukemia and lymphoma.'),
(13, 'Dr. Michael Lee', 36, 'Male', '2357893422', '654 Maple St, Metropolis', '2006', 'michaellee@gmail.com', '1989-07-12', 'Pediatric Oncology', 'MD', '../img/DoctorImage/Lee.jpg', 'Pediatric oncologist dedicated to providing compassionate care for young cancer patients.'),
(14, 'Dr. Jasmine Jasmine', 35, 'Female', '0768530299', '125 Main St, Springfield', '2007', 'jas@gmaiol.com', '1990-07-19', 'Psycho-Oncologist', 'MBBS/MA in Psychology ', '../img/DoctorImage/Jasmine.webp', 'Provides emotional and psychological support to patients and families coping with cancer diagnosis and treatment.');

-- --------------------------------------------------------

--
-- Table structure for table `drugs`
--

CREATE TABLE `drugs` (
  `drugID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drugs`
--

INSERT INTO `drugs` (`drugID`, `Name`, `Type`, `Price`, `Description`, `Image`) VALUES
(1, 'Cisplatin', 'Chemotherapy', 150.00, 'A platinum-based drug used to treat various cancers including testicular, ovarian, and bladder cancer. **Side Effects: Nausea, vomiting, kidney damage, hearing loss, low blood cell counts.**', '../UploadImages/Cisplatin.PNG'),
(2, 'Doxorubicin', 'Chemotherapy', 250.00, 'An anthracycline antibiotic used for breast cancer, leukemia, and lymphoma. **Side Effects: Hair loss, mouth sores, heart damage (with long-term use), increased risk of infections.**', '../UploadImages/2.PNG'),
(3, 'Imatinib', 'Targeted Therapy', 350.00, 'A tyrosine kinase inhibitor used primarily for chronic myelogenous leukemia (CML). **Side Effects: Nausea, muscle cramps, skin rashes, fluid retention, fatigue.**', '../UploadImages/3.PNG'),
(4, 'Trastuzumab', 'Targeted Therapy', 400.00, 'A monoclonal antibody used to treat HER2-positive breast cancer and stomach cancer. **Side Effects: Fever, chills, weakness, heart problems, infusion-related reactions.**', '../UploadImages/4.PNG'),
(5, 'Tamoxifen', 'Hormonal Therapy', 100.00, 'A selective estrogen receptor modulator used for hormone receptor-positive breast cancer. **Side Effects: Hot flashes, increased risk of blood clots, uterine cancer, cataracts.**', '../UploadImages/5.PNG'),
(6, 'Pembrolizumab', 'Immunotherapy', 500.00, 'A checkpoint inhibitor that helps the immune system recognize and attack cancer cells. **Side Effects: Fatigue, skin rash, diarrhea, autoimmune reactions (inflammation of organs).**', '../UploadImages/5 HotelLogo.png'),
(7, 'Letrozole', 'Hormonal Therapy', 200.00, 'An aromatase inhibitor used for postmenopausal women with hormone receptor-positive breast cancer. **Side Effects: Joint pain, hot flashes, fatigue, bone thinning.**', '../UploadImages/7.PNG'),
(8, 'Bevacizumab', 'Targeted Therapy', 600.00, 'An angiogenesis inhibitor used in various cancers including colorectal and lung cancer. **Side Effects: High blood pressure, bleeding, blood clots, kidney damage.**', '../UploadImages/3.PNG'),
(12, 'Pembrolizumab', 'Immunotherapy', 250.00, 'Helps immune system recognize and attack cancer cells.', '../UploadImages/OIP.webp');

-- --------------------------------------------------------

--
-- Table structure for table `homevisit`
--

CREATE TABLE `homevisit` (
  `ID` int(11) NOT NULL,
  `PatientName` varchar(255) NOT NULL,
  `Age` int(11) NOT NULL,
  `PhoneNo` varchar(15) NOT NULL,
  `Address` text NOT NULL,
  `Description` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homevisit`
--

INSERT INTO `homevisit` (`ID`, `PatientName`, `Age`, `PhoneNo`, `Address`, `Description`, `CreatedAt`) VALUES
(10, 'Reeshma', 30, '0769893222', '34, Kandy', 'Blood c', '2025-10-20 07:05:00'),
(11, 'Reeshma', 22, '0769893222', '34, Kandy', 'Home visit', '2025-11-05 14:59:30'),
(12, 'Jane', 25, '0757398230', '6A/Galagedara', 'Cancer check', '2025-11-06 05:32:13'),
(13, 'Jam', 40, '0769893220', '56/Geliyoya', 'Home visit', '2025-11-07 06:02:08'),
(14, 'camy', 35, '07899891323', '6A/ Galagedara', 'Home ', '2025-11-07 07:08:59');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `InvoiceID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `PatientName` varchar(100) NOT NULL,
  `NIC` varchar(20) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`InvoiceID`, `OrderID`, `PatientName`, `NIC`, `Amount`, `Date`) VALUES
(12, 33, 'fathima', '200380', 3750.00, '2025-10-22 00:00:00'),
(13, 45, 'Reeshmaa', '8000', 3800.00, '2025-11-05 00:00:00'),
(14, 47, 'fathima', '200380', 2600.00, '2025-11-05 00:00:00'),
(15, 49, 'Iyer', '1000', 2400.00, '2025-11-06 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `loan_applications`
--

CREATE TABLE `loan_applications` (
  `application_id` int(11) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `gender` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone1` varchar(15) NOT NULL,
  `phone2` varchar(15) DEFAULT NULL,
  `suffering_duration` varchar(50) NOT NULL,
  `loan_service` varchar(100) NOT NULL,
  `help` text NOT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_applications`
--

INSERT INTO `loan_applications` (`application_id`, `patient_name`, `nic`, `gender`, `address`, `phone1`, `phone2`, `suffering_duration`, `loan_service`, `help`, `application_date`) VALUES
(8, 'Reema', '200380', 'Male', '34, Kandy', '1233567885', '24335647', '1 year', 'personal_loan', 'Great need of this loan', '2025-10-19 12:17:40'),
(15, 'Reeshma', '200380', 'Female', '34, Kandy', '1233567885', '24335647', '1 year', 'Educational Loan', 'For my studies', '2025-10-22 03:35:01'),
(17, 'Reeshma', '200380', 'Female', '34, Kandy', '1233567885', '24335647', '1 year', 'Family Support & Living Expense Loan', 'In great need', '2025-11-05 10:27:44'),
(18, 'Jane', '1000', 'Male', '6A/Galagedara', '0757398230', '0757398230', '1 month', 'Personal Loan', 'Need personal loan', '2025-11-06 01:03:35'),
(19, 'Jam', '8001', 'Female', '6A/Galagedara', '1233567880', '1233567880', '1 year', 'Family Support & Living Expense Loan', 'Family support', '2025-11-07 01:32:56');

-- --------------------------------------------------------

--
-- Table structure for table `loan_services`
--

CREATE TABLE `loan_services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_image` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_services`
--

INSERT INTO `loan_services` (`service_id`, `service_name`, `service_image`, `description`) VALUES
(24, 'Family Support & Living Expense Loan', '../img/LoanServiceIMG/1.png', 'Support family who has cancer'),
(26, 'Educational Loan', '../img/LoanServiceIMG/3.png', 'Supports patients or family members whose education was disrupted due to treatment costs. '),
(28, 'Recovery Loan', '../img/LoanServiceIMG/5.png', 'Helps survivors rebuild their lives after treatment by covering the costs.'),
(29, 'Personal Loan', '../img/LoanServiceIMG/2.png', 'A multi-purpose loan that can be used to manage various expenses'),
(30, 'Medical Loan', '../img/LoanServiceIMG/6.png', 'Covering expenses related to cancer treatment such as surgeries, medicines, and hospital bills.');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `NIC` varchar(20) NOT NULL,
  `ItemList` text NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Method` varchar(20) NOT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Pending',
  `Date` datetime DEFAULT current_timestamp(),
  `Comment` varchar(256) DEFAULT NULL,
  `Payment` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `NIC`, `ItemList`, `Amount`, `Method`, `Status`, `Date`, `Comment`, `Payment`) VALUES
(26, '200380', 'Cisplatin', 150.00, 'Cash on Delivery', 'Delivered', '2025-07-06 00:00:00', '', 'Paid'),
(27, '200380', '\"[\\\"Doxorubicin\\\"]\"', 3750.00, 'Cash on Delivery', 'Delivered', '2025-10-20 00:00:00', NULL, 'Paid'),
(33, '200380', '\"[\\\"Doxorubicin\\\"]\"', 3750.00, 'Cash on Delivery', 'Delivered', '2025-10-22 00:00:00', NULL, 'Paid'),
(35, '200380', '\"[\\\"Doxorubicin\\\"]\"', 3750.00, 'Cash on Delivery', 'Delivered', '2025-10-22 00:00:00', NULL, 'Paid'),
(43, '9000', 'Imatinib\nTrastuzumab', 750.00, 'Online Payment', 'Delivered', '2025-10-27 00:00:00', NULL, 'Paid'),
(44, '8000', 'Letrozole\nPembrolizumab', 700.00, 'Online Payment', 'Delivered', '2025-11-05 00:00:00', NULL, 'Paid'),
(45, '8000', '[\"Cisplatin\",\"Doxorubicin\",\"Trastuzumab\"]', 3800.00, 'Online Payment', 'Delivered', '2025-11-05 00:00:00', NULL, 'Paid'),
(46, '200380', 'Cisplatin\nDoxorubicin', 400.00, 'Online Payment', 'Delivered', '2025-11-05 00:00:00', NULL, 'Paid'),
(47, '200380', '[\"Doxorubicin\",\"Imatinib\"]', 2600.00, 'Online Payment', 'Delivered', '2025-11-05 00:00:00', NULL, 'Paid'),
(48, '1000', 'Pembrolizumab\nLetrozole', 1200.00, 'Online Payment', 'Pending', '2025-11-06 00:00:00', 'Good', 'Paid'),
(49, '1000', '[\"Cisplatin\",\"Doxorubicin\"]', 2400.00, 'Online Payment', 'Delivered', '2025-11-06 00:00:00', 'Received', 'Paid'),
(51, '1000', '[\"Doxorubicin\",\"Trastuzumab\"]', 3150.00, 'Online Payment', 'Paid', '2025-11-06 00:00:00', NULL, 'Stripe'),
(52, '1000', '[\"Imatinib\"]', 2850.00, 'Online Payment', 'Paid', '2025-11-06 00:00:00', NULL, 'Stripe'),
(58, '8000', 'Cisplatin', 150.00, 'Online Payment', 'Pending', '2025-11-06 00:00:00', NULL, 'Paid'),
(59, '8000', 'Cisplatin\nDoxorubicin', 400.00, 'Online Payment', 'Pending', '2025-11-06 00:00:00', NULL, 'Paid'),
(60, '8000', '[\"Tamoxifen\",\"Pembrolizumab\"]', 3600.00, 'Online Payment', 'Paid', '2025-11-06 00:00:00', NULL, 'Stripe'),
(61, '8000', 'Cisplatin\nDoxorubicin', 400.00, 'Online Payment', 'Pending', '2025-11-07 00:00:00', NULL, 'Paid'),
(62, '8000', 'Cisplatin', 150.00, 'Online Payment', 'Pending', '2025-11-07 00:00:00', NULL, 'Paid'),
(63, '8000', '[\"Tamoxifen\",\"Pembrolizumab\"]', 3600.00, 'Online Payment', 'Paid', '2025-11-07 00:00:00', NULL, 'Stripe'),
(64, '8000', 'Doxorubicin\nImatinib', 600.00, 'Online Payment', 'Pending', '2025-11-07 00:00:00', NULL, 'Paid'),
(65, '8000', 'Doxorubicin\nImatinib', 600.00, 'Online Payment', 'Pending', '2025-11-07 00:00:00', NULL, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `query`
--

CREATE TABLE `query` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `phoneno` varchar(15) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `query`
--

INSERT INTO `query` (`id`, `name`, `email`, `nic`, `phoneno`, `subject`, `message`, `created_at`) VALUES
(2, 'fathima reeshma', 'reeshma@gmail.com', '200380', '0767005675', 'reeshma', 'HI', '2025-10-27 13:13:15'),
(3, 'fathima reeshma', 'reeshma@gmail.com', '200380', '0767005675', 'reeshma', 'good', '2025-10-27 13:25:53'),
(4, 'fathima reeshma', 'reeshma@gmail.com', '200380', '0767005675', 'reeshma', 'Make some medications in medications', '2025-10-27 09:12:38'),
(5, 'David', 'david@123', '200380', '0768530296', 'Cancer', 'Good job', '2025-10-27 09:13:24'),
(6, 'David', 'david@123', '200380', '0768530296', 'Cancer', 'goood', '2025-11-05 04:16:41'),
(7, 'David', 'david@123', '200380', '0768530296', 'Cancer', 'goood', '2025-11-05 04:17:36'),
(8, 'Jammy Jam', 'jam@gmail.com', '8001', '0757398232', 'Cancer', 'Need mobile application ', '2025-11-07 01:34:31');

-- --------------------------------------------------------

--
-- Table structure for table `support_programs`
--

CREATE TABLE `support_programs` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `modal_content` text NOT NULL,
  `session_info` varchar(255) DEFAULT NULL,
  `button_text` varchar(50) DEFAULT NULL,
  `button_link` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `support_programs`
--

INSERT INTO `support_programs` (`id`, `title`, `description`, `modal_content`, `session_info`, `button_text`, `button_link`, `created_at`) VALUES
(1, 'Emotional Support Group', 'Join our weekly support groups facilitated by counselors, where patients and families can share experiences and build resilience together.', 'Our emotional support group meets every Thursday at 5 PM. Led by experienced counselors, this program provides a safe space to share experiences, gain support, and find community with other patients and families.', 'Next session: Thursday, 6PM', 'Join the Support Group', 'https://web.whatsapp.com', '2024-11-04 15:30:55'),
(2, 'Financial Aid Assistance', 'Find out about available financial assistance programs that can help cover medical bills and living expenses during treatment.', 'Our financial aid assistance program is designed to support patients with medical and living expenses during treatment. Apply for aid through our streamlined application process and speak with a financial advisor.', 'Eligibility: Open to all registered patients.', 'Apply for Assistance', '#', '2024-11-04 15:30:55'),
(6, 'Free Prescriptions Program', 'Our national directory includes hundreds! If you or a loved one has been diagnosed with cancer, please reach out today for the support you deserve.', 'Cancer is such an expensive disease. Anyone who’s been through it knows that it takes its toll physically, emotionally, and financially. But did you know there are many nonprofit programs available that can help? Our national directory includes hundreds! If you or a loved one has been diagnosed with cancer, please reach out today for the support you deserve.', 'Next session: Sunday, 8PM', 'Visit Link to participate', 'https://cancercarenews.com/free-financial-help-for-cancer-patients/prescriptions/', '2025-11-06 05:43:06');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `NIC` varchar(15) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `usertype` varchar(255) NOT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `FirstName`, `LastName`, `NIC`, `Email`, `Password`, `usertype`, `status`) VALUES
(1, 'Sam', 'Smith', '2012024534', 'sam@gmail.com', '56fafa8964024efa410773781a5f9e93', 'Client', 0),
(3, 'admin', 'admin', '2000123456', 'admin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Admin', 0),
(22, 'reeshma', 'reeshma', '123', '1234@gmail.com', '202cb962ac59075b964b07152d234b70', 'Client', 0),
(23, 'Abraham', 'Hash', '2005', 'abraham@123', '202cb962ac59075b964b07152d234b70', 'Doctor', 1),
(24, 'Dr. John ', 'Doe', '2000', 'Johndoe@gamil.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Doctor', 1),
(25, 'Dr. Jane ', 'Smith', '2001', 'janesmith@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Doctor', 1),
(26, 'Dr. Robert ', 'Brown', '2002', 'robertbrown@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Doctor', 1),
(27, 'Dr. Emily ', 'Johnson', '2003', 'emilyjohnson@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Doctor', 1),
(31, 'Dr. Michael', 'Lee', '2006', 'michaellee@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Doctor', 1),
(33, 'reshma', 'jawfer', '0987', 'reesh@gmail.com', '202cb962ac59075b964b07152d234b70', 'Client', 0),
(36, 'atheef', 'atheef', '200030004000', 'athee@123', '202cb962ac59075b964b07152d234b70', 'Client', 0),
(38, 'Anu', 'sam', '9000', 'anu@gmail.com', '202cb962ac59075b964b07152d234b70', 'Client', 0),
(39, 'Sam', 'Camy', '8000', 'camy@gmail.com', '202cb962ac59075b964b07152d234b70', 'Client', 0),
(40, 'Iyer', 'Jane', '1000', 'jane@gmail.com', '202cb962ac59075b964b07152d234b70', 'Client', 0),
(42, 'Dr. Jasmine', 'Jasmine', '2007', 'jas@gmaiol.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Doctor', 1),
(43, 'Jammy', 'Jam', '8001', 'jam@gmail.com', '202cb962ac59075b964b07152d234b70', 'Client', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartID`),
  ADD KEY `user_NIC` (`user_NIC`),
  ADD KEY `drugID` (`drugID`);

--
-- Indexes for table `consult_appointment`
--
ALTER TABLE `consult_appointment`
  ADD PRIMARY KEY (`CON_APP_ID`);

--
-- Indexes for table `doctor_consultation_response`
--
ALTER TABLE `doctor_consultation_response`
  ADD PRIMARY KEY (`Con_Doc_Res_ID`);

--
-- Indexes for table `doctor_details`
--
ALTER TABLE `doctor_details`
  ADD PRIMARY KEY (`Doctor_ID`),
  ADD UNIQUE KEY `NIC` (`NIC`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `drugs`
--
ALTER TABLE `drugs`
  ADD PRIMARY KEY (`drugID`);

--
-- Indexes for table `homevisit`
--
ALTER TABLE `homevisit`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`InvoiceID`);

--
-- Indexes for table `loan_applications`
--
ALTER TABLE `loan_applications`
  ADD PRIMARY KEY (`application_id`);

--
-- Indexes for table `loan_services`
--
ALTER TABLE `loan_services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `query`
--
ALTER TABLE `query`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_programs`
--
ALTER TABLE `support_programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_nic` (`NIC`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `consult_appointment`
--
ALTER TABLE `consult_appointment`
  MODIFY `CON_APP_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `doctor_consultation_response`
--
ALTER TABLE `doctor_consultation_response`
  MODIFY `Con_Doc_Res_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `doctor_details`
--
ALTER TABLE `doctor_details`
  MODIFY `Doctor_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `drugs`
--
ALTER TABLE `drugs`
  MODIFY `drugID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `homevisit`
--
ALTER TABLE `homevisit`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `InvoiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `loan_applications`
--
ALTER TABLE `loan_applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `loan_services`
--
ALTER TABLE `loan_services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `query`
--
ALTER TABLE `query`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `support_programs`
--
ALTER TABLE `support_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_NIC`) REFERENCES `user` (`NIC`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`drugID`) REFERENCES `drugs` (`drugID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
