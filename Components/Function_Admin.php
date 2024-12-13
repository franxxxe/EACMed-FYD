<?php
include '../Config/Configure.php';
date_default_timezone_set("Asia/Manila");
$Date = date("Y-m-d");
$Time = date("h:i:sa");
$Day = date('l');

//CREATE RANDOM ID
function generateDoctorAccountId() {
  $date = date("Ymd");
  $randomNumber = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
  $accountId = $date . '-' . $randomNumber;
  return $accountId;
}


// PAGINATION
if (isset($_POST["page"])) {
  $page = $_POST['page'];
  $limit = 5; // Number of records per page
  $start = ($page - 1) * $limit;
  $query = "SELECT * FROM hmo LIMIT $start, $limit";
  $result = mysqli_query($connMysqli, $query);
  $output = '';
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $output .= '<div>' . $row['hmo_name'] . '</div>';
    }
    // Pagination links
    $query_total = "SELECT * FROM hmo";
    $result_total = mysqli_query($connMysqli, $query_total);
    $total_records = mysqli_num_rows($result_total);
    $total_pages = ceil($total_records / $limit);

    $output .= '<ul class="pagination">';
    for ($i = 1; $i <= $total_pages; $i++) {
      $active = ($i == $page) ? 'active' : '';
      $output .= '<li class="page-item ' . $active . '"> <a class="page-link" href="#sdf' . $i . '" data-page="' . $i . '"><button>' . $i . '</button></a></li>';
    }
    $output .= '</ul>';
  } else {
    $output .= '<p>No data found</p>';
  }
  echo $output;
}


// INSERT NEW DOCTOR
if (isset($_POST["InsertDoctor"])) {
  global $connMysqli;
  $LastName = $_POST["LastName"];
  $MiddleName = $_POST["MiddleName"];
  $FirstName = $_POST["FirstName"];
  $Gender = $_POST["Gender"];
  $Category = $_POST["Category"];
  $Specialization = $_POST["Specialization"];
  $SubSpecialization = $_POST["SubSpecialization"];
  $Schedule = $_POST["Schedule"];
  $Room = $_POST["Room"];
  $HMOAccreditation = $_POST["HMOAccreditation"];
  $TeleConsultation = $_POST["TeleConsultation"];
  $Remarks = $_POST["Remarks"];

  $PrimarySecretary = $_POST["PrimarySecretary"];
  $PrimaryFirstNumber = $_POST["PrimaryFirstNumber"];
  $PrimaryFirstNetwork = $_POST["PrimaryFirstNetwork"];
  $PrimarySecondNumber = $_POST["PrimarySecondNumber"];
  $PrimarySecondNetwork = $_POST["PrimarySecondNetwork"];
  $SecondarySecretary = $_POST["SecondarySecretary"];
  $SecondarySecondNumber = $_POST["SecondarySecondNumber"];
  $SecondarySecondNetwork = $_POST["SecondarySecondNetwork"];

  if ($Gender == "Male") {
    $Profile_Img = "Doctor1.png";
  } else {
    $Profile_Img = "Doctor2.png";
  }

  $doctorAccountId = generateDoctorAccountId();

  if (!empty($Specialization) && is_array($Specialization)) {
    $ids = implode(",", array_map('intval', $Specialization));
  
    $DoctorSpecsFetchQuery = "SELECT * FROM specialization WHERE specialization_id IN ($ids)";
    $stmt = $connPDO->query($DoctorSpecsFetchQuery);
    $fetchedSpecializations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $InsertDoctorSpecs = $connPDO->prepare("INSERT INTO `doctor_specialization` (specialization_doctor_id, specialization_id_2, doctor_specialization_name) VALUES (?,?,?)");

    foreach ($fetchedSpecializations as $spec) {
        $InsertDoctorSpecs->execute([$doctorAccountId, $spec['specialization_id'], $spec['specialization_name']]);
    }
  } else {
      echo "No valid specializations selected.";
  }


  if (!empty($SubSpecialization) && is_array($SubSpecialization)) {
    $ids = implode(",", array_map('intval', $SubSpecialization));

    $DoctorSubSpecsFetchQuery = "SELECT * FROM sub_specialization WHERE sub_specialization_id IN ($ids)";
    $stmt = $connPDO->query($DoctorSubSpecsFetchQuery);
    $fetchedSpecializations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $InsertDoctorSpecs = $connPDO->prepare("INSERT INTO `doctor_sub_specialization` (sub_specialization_doctor_id, sub_specialization_id_2, doctor_sub_specialization_name) VALUES (?,?,?)");

    foreach ($fetchedSpecializations as $spec) {
        $InsertDoctorSpecs->execute([$doctorAccountId, $spec['sub_specialization_id'], $spec['sub_specialization_name']]);
    }

  } else {
      echo "No valid specializations selected.";
  }


  if (!empty($Schedule) && is_array($Schedule)) {
    foreach ($Schedule as $schedule) {
        [$doctor_schedule_day, $doctor_schedule_time] = explode(", ", $schedule);
        $InsertDoctorSchedule = $connPDO->prepare("INSERT INTO `doctor_schedule` (schedule_doctor_id, doctor_schedule_day, doctor_schedule_time) VALUES (?, ?, ?)");
        $InsertDoctorSchedule->execute([$doctorAccountId, $doctor_schedule_day, $doctor_schedule_time]);
    }
  } else {
      echo "No valid schedules found.";
  }

  if (!empty($Room) && is_array($Room)) {
    $ids = implode(",", array_map('intval', $Room));
  
    $DoctorSpecsFetchQuery = "SELECT * FROM room WHERE room_id IN ($ids)";
    $stmt = $connPDO->query($DoctorSpecsFetchQuery);
    $fetchedRoom = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (!$DoctorSpecsFetchQuery) {
      die('MySQL ErrorL ' . mysqli_error($conn));
    }
    $InsertDoctorSpecs = $connPDO->prepare("INSERT INTO `doctor_room` (room_doctor_id,doctor_room_number) VALUES (?,?)");

    foreach ($fetchedRoom as $spec) {
        $InsertDoctorSpecs->execute([$doctorAccountId, $spec['room_floor_name']]);
    }
  } else {
      echo "No valid Room selected.";
  }

  if (!empty($HMOAccreditation) && is_array($HMOAccreditation)) {
    $ids = implode(",", array_map('intval', $HMOAccreditation));
  
    $DoctorSpecsFetchQuery = "SELECT * FROM hmo WHERE hmo_id IN ($ids)";
    $stmt = $connPDO->query($DoctorSpecsFetchQuery);
    $fetchedSpecializations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $InsertDoctorSpecs = $connPDO->prepare("INSERT INTO `doctor_hmo` (hmo_doctor_id, hmo_id_2, doctor_hmo_name) VALUES (?,?,?)");

    foreach ($fetchedSpecializations as $spec) {
        $InsertDoctorSpecs->execute([$doctorAccountId, $spec['hmo_id'], $spec['hmo_name']]);
    }
  } else {
      echo "No valid specializations selected.";
  }


  $InsertDoctor = $connPDO->prepare("INSERT INTO `doctor`(doctor_account_id, doctor_firstname, doctor_middlename, doctor_lastname, doctor_category, profile_image, doctor_sex) VALUES(?,?,?,?,?,?,?)");
  $InsertDoctor->execute([$doctorAccountId, $FirstName, $MiddleName, $LastName, $Category, $Profile_Img, $Gender]);

  $InsertConsultation = $connPDO->prepare("INSERT INTO `doctor_teleconsult`(teleconsult_doctor_id, teleconsult_link) VALUES(?,?)");
  $InsertConsultation->execute([$doctorAccountId, $TeleConsultation]);

  $InsertRemarks = $connPDO->prepare("INSERT INTO `doctor_notes`(notes_doctor_id, doctor_notes_details) VALUES(?,?)");
  $InsertRemarks->execute([$doctorAccountId, $Remarks]);

  echo "Doctor have been successfully inserted!";

}


// ACCESS ACCOUNT
if (isset($_POST["AccessAccount"])) {
  global $connMysqli;

  $AccessUsername = $_POST["AccessUsername"];
  $AccessType = $_POST["AccessType"];
  $DefaultAccess = '$2y$10$TX6XGGHg9b5BrZuHA6bJCOa9scgvdYtv1CUc1S1oQIcVPPES5SpyW';
  $StrTimestamp = strtotime("$Date $Time");
  $Current_Timestamp = date("Y-m-d H:i:s", $StrTimestamp);
  $AccountStatus = 'New';
  $DefaultStatus = 'Active';

  $InsertAdmin = $connPDO->prepare("INSERT INTO `admin_accounts`(admin_username, admin_password, admin_account_status, admin_status, account_access, account_created_timestamp) VALUES(?, ?, ?, ?, ?, ?)");
  $InsertAdmin->execute([$AccessUsername, $DefaultAccess, $AccountStatus, $DefaultStatus, $AccessType, $Current_Timestamp]);
}


// VIEW ADMIN
if (isset($_POST["ViewAdmin_ID"])) {
  global $connMysqli;
  $Admin_ID = $_POST["ViewAdmin_ID"];

  $AdminFetchQuery = "SELECT * from admin_accounts
  WHERE admin_id = '$Admin_ID'";
  $AdminFetchQuery = mysqli_query($connMysqli, $AdminFetchQuery);

  if (!$AdminFetchQuery) {
    die('MySQL ErrorL ' . mysqli_error($conn));
  }
  if ($AdminFetchQuery->num_rows > 0) {
    while ($row1 = mysqli_fetch_assoc($AdminFetchQuery)) {
      echo " 
            <div class='Modal-Sidebar-Top'>
              <i class='fa-solid fa-user-tie'></i>
              <h4>Admin Account</h4>
            </div>
            <div class='Modal-Sidebar-Main'>
              <div class='ModalSidebar-Container AddDoctorDivContainer-Form'>
                <div class='Div-Container1'>
                  <div class='Doctor-Img-Profile'><img src='../Uploaded/Doctor1.png' alt=''></div>
                  <div class=''>
                    <p>" . $row1['admin_username'] . "</p>
                    <div class='Doctor-Active Doctor-Capitalize'><i class='fa-solid fa-circle'></i><span>" . $row1['admin_status'] . "</span></div>
                  </div>
                </div>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Access Level:</i>
                  <div class='InputFieldForm-Info'> <span> " . $row1['account_access'] . " </span> </div>
                </div>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Created on</i>
                  <div class='InputFieldForm-Info'> <span> " . $row1['account_created_timestamp'] . " </span> </div>
                </div>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Last edited on</i>
                  <div class='InputFieldForm-Info'> 
                    <span> " . $row1['account_created_timestamp'] . " </span> 
                    <br>
                    <span> (by a Super Admin) </span>
                  </div>
                </div>

                
                <!-- <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Remarks:</i>

                  <div class='InformationField'></div>
                </div> -->
              </div>
            </div>
            <div class='Modal-Sidebar-Bottom'>
              <button class='Btn_1' onclick='EditAdmin(" . $row1['admin_id'] . ")'>Edit</button>
              <button class='Btn_2' onclick='ResetPasswordAdmin(" . $row1['admin_id'] . ")'>Reset Password</button>
            </div> ";
    };
  } else {
    echo "No Data Found";
  }
}


//PROMPT - RESET PASSWORD - ADMIN (FUNCTION)
if (isset($_POST["ResetPasswordAdmin_ID"])) {
  global $connMysqli;
  $Admin_ID = $_POST["ResetPasswordAdmin_ID"];

  $AdminFetchQuery = "SELECT * from admin_accounts
  WHERE admin_id = '$Admin_ID'";
  $AdminFetchQuery = mysqli_query($connMysqli, $AdminFetchQuery);

  if (!$AdminFetchQuery) {
    die('MySQL ErrorL ' . mysqli_error($conn));
  }
  if ($AdminFetchQuery->num_rows > 0) {
    while ($row1 = mysqli_fetch_assoc($AdminFetchQuery)) {
      echo " 
      <div class='Prompt-Message-Top'>
            <lord-icon src='https://cdn.lordicon.com/ygvjgdmk.json' trigger='loop' delay='1500' class='lord-icon'></lord-icon>
            <h4>Are you sure?</h4>
          </div>
          <div class='Prompt-Message-Center'>
            <p class='P-Message'>Are you sure you want to reset the password of this admin account?</p>
          </div>
          <div class='Prompt-Message-Bottom'>
            <button class='Btn_1' onclick='Yes_ResetPasswordAdmin(" . $Admin_ID . ")'>Yes</button>
            <button class='Btn_2' onclick='HidePromptMessage()'>No</button>
      </div>";
    };
  } else {
    echo "No Data Found";
  }
}


//RESET PASSWORD - ADMIN
if (isset($_POST["Yes_ResetPasswordAdmin_ID"])) {
  global $connMysqli;
  $Admin_ID = $_POST["Yes_ResetPasswordAdmin_ID"];
  $AdminDefaultPass = '$2y$10$ZkgThNp4XqRGDaXyuXVtr.5RGI0DsFW3Bop9MW1m.ZE7WVT6AnHvO';

  $ResetPasswordValidation = "SELECT * from admin_accounts 
  WHERE admin_id = '$Admin_ID'";
  $ResetPasswordValidation = mysqli_query($connMysqli, $ResetPasswordValidation);

  if (!$ResetPasswordValidation) {
    die('MySQL ErrorL ' . mysqli_error($conn));
  }
  if ($ResetPasswordValidation->num_rows > 0) {
    while ($row1 = mysqli_fetch_assoc($ResetPasswordValidation)) {
      $Admin_Password = $row1['admin_password'];

      if ($Admin_Password === $AdminDefaultPass) {
        echo "Cannot be changed";
      } else {
        // UPDATE RESET PASSWORD - ADMIN
        $ResetPasswordQuery = "UPDATE admin_accounts SET
        admin_password = '$AdminDefaultPass'
        WHERE admin_id = '$Admin_ID'";
        mysqli_query($connMysqli, $ResetPasswordQuery);
      }
    };
  } else {
    echo "No Data Found";
  }
}


// Search Doctor Specialization
if (isset($_POST["SearchSpecs"])) {
  global $connMysqli;
  
  $Admin_ID = $_POST["SpecializationInput"];
  echo $Admin_ID;
}


// VIEW DOCTOR
if (isset($_POST["ViewDoctorType"])) {
  global $connMysqli;
  $ViewDoctorType = $_POST["ViewDoctorType"];
  $ViewDoctor_ID = $_POST["ViewDoctor_ID"];

  if($ViewDoctorType == "View" || $ViewDoctorType == "ArchivedView"){
    $DoctorFetchQuery = "SELECT DISTINCT * from doctor 
    WHERE doctor_account_id = '$ViewDoctor_ID'";
    $DoctorFetchQuery = mysqli_query($connMysqli, $DoctorFetchQuery);
    if (!$DoctorFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorFetchQuery->num_rows > 0) {
      while ($row = mysqli_fetch_assoc($DoctorFetchQuery)) {
        echo " 
          <div class='Modal-Sidebar-Top'>
            <i class='fa-solid fa-user-doctor'></i>
            <h4>Doctor Information</h4>
          </div>
          <div class='Modal-Sidebar-Main'>
            <div class='ModalSidebar-Container AddDoctorDivContainer-Form'>
              <div class='Div-Container1'>
                <div class='Doctor-Img-Profile'><img src='../Uploaded/".$row['profile_image']."' alt=''></div>
                <div class=''>
                  <h3 class='capitalize'>Dr. ".$row['doctor_firstname']." ".substr($row['doctor_middlename'], 0, 1).". ".$row['doctor_lastname']."</h3>
                  <div class='Doctor-Active'><i class='fa-solid fa-circle'></i> ".$row['doctor_status']."</div>
                </div>
              </div>
  
              <div class='InputFieldForm'>
                <i class='InputFieldForm-i'>Category:</i>
                <input type='text' readonly placeholder='' value='".$row['doctor_category']."'>
              </div>
  
              <div class='InputFieldForm'>
                <i class='InputFieldForm-i'>Specialization:</i>
                <div class='InformationField'>
                  ";
                    $DoctorSpecsFetchQuery = "SELECT * from doctor_specialization
                    WHERE specialization_doctor_id = '$ViewDoctor_ID'";
                    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
                    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                    if ($DoctorSpecsFetchQuery->num_rows > 0) {
                      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {echo" 
                          <div class='InformationFieldTag'><p>".$SpecsRow['doctor_specialization_name']."</p> </div>
                        ";
                      }
                    }
                  echo"
                </div>
              </div>
              <div class='InputFieldForm'>
                <i class='InputFieldForm-i'>Sub Specialization:</i>
  
                <div class='InformationField'>
                  ";
                    $DoctorSubSpecsFetchQuery = "SELECT * from doctor_sub_specialization
                    WHERE sub_specialization_doctor_id = '$ViewDoctor_ID'";
                    $DoctorSubSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSubSpecsFetchQuery);
                    if (!$DoctorSubSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                    if ($DoctorSubSpecsFetchQuery->num_rows > 0) {
                      while ($SubSpecsRow = mysqli_fetch_assoc($DoctorSubSpecsFetchQuery)) {echo" 
                          <div class='InformationFieldTag'><p>".$SubSpecsRow['doctor_sub_specialization_name']."</p> </div>
                        ";
                      }
                    }
                  echo"
                </div>
              </div>
              <div class='InputFieldForm'>
                <i class='InputFieldForm-i'>Secretary:</i>
                <div class='InformationField'>";
                    $DoctorSecretaryFetchQuery = "SELECT * from doctor_secretary
                    WHERE secretary_doctor_id = '$ViewDoctor_ID'";
                    $DoctorSecretaryFetchQuery = mysqli_query($connMysqli, $DoctorSecretaryFetchQuery);
                    if (!$DoctorSecretaryFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                    if ($DoctorSecretaryFetchQuery->num_rows > 0) {
                      while ($SecretaryRow = mysqli_fetch_assoc($DoctorSecretaryFetchQuery)) {echo" 
                          <div class='InformationFieldTag'>
                            <p>".$SecretaryRow['doctor_secretary_first_name']."</p> 
                            <ul>
                              <li><i>".$SecretaryRow['doctor_secretary_first_network']."</i> <p>".$SecretaryRow['doctor_secretary_first_number']."</p></li>
                              <li><i>".$SecretaryRow['doctor_secretary_second_network']."</i> <p>".$SecretaryRow['doctor_secretary_second_number']."</p></li>
                            </ul>
  
                          </div>
                        ";
                      }
                    }
                  echo"
                </div>
              </div>
              <div class='InputFieldForm'>
                <i class='InputFieldForm-i'>Room Number:</i>
                <div class='InformationField'>
                  ";
                    $DoctorRoomFetchQuery = "SELECT * from doctor_room
                    WHERE room_doctor_id = '$ViewDoctor_ID'";
                    $DoctorRoomFetchQuery = mysqli_query($connMysqli, $DoctorRoomFetchQuery);
                    if (!$DoctorRoomFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                    if ($DoctorRoomFetchQuery->num_rows > 0) {
                      while ($RoomRow = mysqli_fetch_assoc($DoctorRoomFetchQuery)) {echo" 
                          <div class='InformationFieldTag'><p>".$RoomRow['doctor_room_number']."</p> </div>
                        ";
                      }
                    }
                  echo"
                </div>
              </div>
              
              <div class='InputFieldForm'>
                <i class='InputFieldForm-i'>Schedule:</i>
                <div class='InformationField'>
                  <table class='table-doctor-schedule'>
                      ";
                        $DoctorScheduleFetchQuery = "SELECT * from doctor_schedule
                        WHERE schedule_doctor_id = '$ViewDoctor_ID'";
                        $DoctorScheduleFetchQuery = mysqli_query($connMysqli, $DoctorScheduleFetchQuery);
                        if (!$DoctorScheduleFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                        if ($DoctorScheduleFetchQuery->num_rows > 0) {
                          while ($ScheduleRow = mysqli_fetch_assoc($DoctorScheduleFetchQuery)) {echo" 
                            <tr>
                              <td>".$ScheduleRow['doctor_schedule_day']."</td> 
                              <td>".$ScheduleRow['doctor_schedule_time']."</td> 
                            </tr>
                            ";
                          }
                        }
                      echo"
                  </table>
                  
                </div>
              </div>
  
              <div class='InputFieldForm'>
                <i class='InputFieldForm-i'>HMO Accreditation:</i>
  
                <div class='InformationField'>
                  ";
                    $DoctorHMOFetchQuery = "SELECT * from doctor_hmo
                    WHERE hmo_doctor_id = '$ViewDoctor_ID' ORDER BY doctor_hmo_name";
                    $DoctorHMOFetchQuery = mysqli_query($connMysqli, $DoctorHMOFetchQuery);
                    if (!$DoctorHMOFetchQuery) {die('MySQL ErrorL ' . mysqli_error($DoctorHMOFetchQuery));}
                    if ($DoctorHMOFetchQuery->num_rows > 0) {
                      while ($HMOrow = mysqli_fetch_assoc($DoctorHMOFetchQuery)) {echo" 
                          <div class='InformationFieldTag'><p>".$HMOrow['doctor_hmo_name']."</p></div> 
                        ";
                      }
                    }
                  echo"
                </div>
              </div>
              <div class='InputFieldForm'>
                <i class='InputFieldForm-i'>Remarks:</i>
                <div class='InformationField'>
                  ";
                    $DoctorNotesFetchQuery = "SELECT * from doctor_notes
                    WHERE notes_doctor_id = '$ViewDoctor_ID'";
                    $DoctorNotesFetchQuery = mysqli_query($connMysqli, $DoctorNotesFetchQuery);
                    if (!$DoctorNotesFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
                    if ($DoctorNotesFetchQuery->num_rows > 0) {
                      while ($NotesRow = mysqli_fetch_assoc($DoctorNotesFetchQuery)) {echo" 
                          <p>".$NotesRow['doctor_notes_details']."</p> 
                        ";
                      }
                    }
                  echo"
                </div>
              </div>
            </div>
          </div>
          <div class='Modal-Sidebar-Bottom'>
            <button class='Btn_1' onclick='EditDoctor(`".$row['doctor_account_id']."`)'>Edit</button>
            <button class='Btn_2' onclick='PromptDoctor(`RemoveDoctor`,`".$row['doctor_account_id']."`)'>Delete</button>
          </div>
        ";
      };
    } else {
      echo "No Data Found";
    }
  }
}


// EDIT MODAL DOCTOR
if (isset($_POST["ViewEdit_ID"])) {
  global $connMysqli;
  $ViewEdit_ID = $_POST["ViewEdit_ID"];
  $DoctorFetchQuery = "SELECT * from doctor 
  WHERE doctor_account_id = '$ViewEdit_ID'";
  $DoctorFetchQuery = mysqli_query($connMysqli, $DoctorFetchQuery);
  if (!$DoctorFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
  if ($DoctorFetchQuery->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($DoctorFetchQuery)) {
      $DoctorSex = $row['doctor_sex'];
      $DoctorCategory = $row['doctor_category'];
      if($DoctorSex == "Male"){$SelectedSexIsMale = "Selected"; $SelectedSexIsFemale = "";}
      else{$SelectedSexIsFemale = "Selected";$SelectedSexIsMale = "";}
      if($DoctorCategory == "Regular Consultant"){$DocCategoryRegular = "Selected"; $DocCategoryWaiting = "";}
      else{$DocCategoryWaiting = "Selected";$DocCategoryRegular = "";}

      echo " 
        <div class='Modal-Sidebar-Top'>
          <i class='fa-solid fa-user-pen'></i>
          <h4>Edit Doctor</h4>
        </div>
        <div class='Modal-Sidebar-Main'>
          <div class='EditDoctorDivContainer-Form'>
            <div class='editDoctor-navigation'>
              <ul>
                <li onclick='editNav(1)' class='edit-nav1 editNavActive'>Doctor</li>
                <li onclick='editNav(2)' class='edit-nav2 editNavInactive'>Secretary</li>
              </ul>
            </div>
            <div class='editDoctor-Container'>

              <div class='editDoctor-Child1'>
              

                <h4>Doctor</h4>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Last Name:</i>
                  <input type='text' placeholder='Last Name' value='".$row['doctor_lastname']."'>
                </div>
                <br>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>First Name:</i>
                  <input type='text' placeholder='First Name' value='".$row['doctor_firstname']."'>
                </div>
                <br>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Gender:</i>
                  <select name='' id=''>
                    <option value='' $SelectedSexIsMale>Male</option>
                    <option value='' $SelectedSexIsFemale>Female</option>
                  </select>
                </div>
                <br>
                <h4>Category</h4>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Category:</i>
                  <select name='' id=''>
                    <option value='' $DocCategoryRegular>Regular Consultant</option>
                    <option value='' $DocCategoryWaiting>Visiting Consultant</option>
                  </select>
                </div>
                <br>
                <hr>
                <br>


                <h4>Specialization</h4>
                <div class='InputFieldForm'>
                  <div class='InputFieldFormChild1'>
                    <i class='InputFieldForm-i'>Specialization:</i>
                    <button class='Btn_1'>Add Specialization</button>
                  </div>
                  <div class='searchContainer-Parent'>
                    <div class='inputFlex'>
                      <input type='text' onkeyup='editSearch(1)' id='editSearch1' placeholder='Search Specialization'>
                      <div class='inputFlexIcon' onclick='closeSearch(1)'><i class='fa-solid fa-xmark'></i></div>
                    </div>
                    
                    <div class='hiddenContainer'>
                      <ul id='EditDropdown1'>
                      
                      </ul>
                    </div>
                  </div>
                </div>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'></i>
                  <div class='InputFieldForm-i-div'>
                    <div class='hiddenInformationField' id='hiddenInformationFieldIDSpecs'>
                      hello
                    </div>

                    <!-- 
                    <div class='InformationField'>
                      worlddd
                    </div>
                    -->
                  </div>
                </div>

                <br>

                <h4>Sub Specialization</h4>
                <div class='InputFieldForm'>
                  <div class='InputFieldFormChild1'>
                    <i class='InputFieldForm-i'>Sub Specialization:</i>
                    <button class='Btn_1'>Add Sub Specialization</button>
                  </div>
                  <div class='searchContainer-Parent'>
                    <div class='inputFlex'>
                      <input type='text' onkeyup='editSearch(2)' id='editSearch2' placeholder='Search Sub Specialization'>
                      <div class='inputFlexIcon' onclick='closeSearch(2)'><i class='fa-solid fa-xmark'></i></div>
                    </div>
                    
                    <div class='hiddenContainer'>
                      <ul>
                        <li>Alfelor</li>
                        <li>Alfelor</li>
                        <li>Alfelor</li>
                        <li>Alfelor</li>
                        <li>Alfelor</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'></i>
                  <div class='InformationField'></div>
                </div>



                <br>
                <hr>
                <br>
                <h4>Schedule</h4>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Schedule:</i>
                  <div class='InputFieldForm-div'>
                    <div class='InputFieldForm-schedule'>
                      <p>Select Day</p>
                      <select id='day-select' name='day-select'>
                        <option value='Monday'>Monday</option>
                        <option value='Tuesday'>Tuesday</option>
                        <option value='Wednesday'>Wednesday</option>
                        <option value='Thursday'>Thursday</option>
                        <option value='Friday'>Friday</option>
                        <option value='Saturday'>Saturday</option>
                        <option value='Sunday'>Sunday</option>
                      </select>
                    </div>
                    <div class='InputFieldForm-divFlexColumn'>
                      <div class='InputFieldForm-schedule'>
                        <p>Time Start</p>
                        <input type='time' id='pick-time' name='pick-time'>
                      </div>
                      <div class='InputFieldForm-schedule'>
                        <p>Time End</p>
                        <input type='time' id='pick-time' name='pick-time'>
                      </div>
                      <div class='InputFieldForm-schedule'>
                        <button class='Btn_1'>Add</button>
                      </div>
                    </div>
                  </div>
                </div>

                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'></i>
                  <div class='InformationField'></div>
                </div>
 
 
 
 




                
                <h4>Room</h4>
                <div class='InputFieldForm'>
                  <div class='InputFieldFormChild1'>
                    <i class='InputFieldForm-i'>Room:</i>
                    <button class='Btn_1'>Add Room</button>
                  </div>
                  <div class='searchContainer-Parent'>
                    <div class='inputFlex'>
                      <input type='text' onkeyup='editSearch(3)' id='editSearch3' placeholder='Search Room'>
                      <div class='inputFlexIcon' onclick='closeSearch(3)'><i class='fa-solid fa-xmark'></i></div>
                    </div>
                    
                    <div class='hiddenContainer'>
                      <ul>
                        <li>Alfelor</li>
                        <li>Alfelor</li>
                        <li>Alfelor</li>
                        <li>Alfelor</li>
                        <li>Alfelor</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'></i>
                  <div class='InformationField'></div>
                </div>



                <br>

                <h4>HMO Accreditation</h4>
                <div class='InputFieldForm'>
                  <div class='InputFieldFormChild1'>
                    <i class='InputFieldForm-i'>HMO Accreditation:</i>
                    <button class='Btn_1'>Add HMO Accreditation</button>
                  </div>
                  <div class='searchContainer-Parent'>
                    <div class='inputFlex'>
                      <input type='text' onkeyup='editSearch(4)' id='editSearch4' placeholder='Search HMO Accreditation'>
                      <div class='inputFlexIcon' onclick='closeSearch(4)'><i class='fa-solid fa-xmark'></i></div>
                    </div>
                    
                    <div class='hiddenContainer'>
                      <ul>
                        <li>Alfelor</li>
                        <li>Alfelor</li>
                        <li>Alfelor</li>
                        <li>Alfelor</li>
                        <li>Alfelor</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'></i>
                  <div class='InformationField'></div>
                </div>

                <br>

                <h4>Teleconsultaion</h4>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Teleconsultaion:</i>
                  <input type='text' placeholder='Teleconsultaion'>
                </div>

                <br>
                <hr>
                <br>

                <h4>Remarks</h4>
                <div class='InputFieldForm'>
                  <i class='InputFieldForm-i'>Remarks:</i>
                  <div class='InformationField'></div>
                </div>
              


              </div>

              <div class='editDoctor-Child2'>
                <h4>Secretary</h4>
                <table>
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Primary Number</th>
                      <th>Secondary Number</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>France Joshua Alfelor</td>
                      <td><p>09783746283</p><p>Globe</p></td>
                      <td><p>09783746283</p><p>Globe</p></td>
                      <td><button>Delete</button></td>
                      
                    </tr>
                    <tr>
                      <td>France Joshua Alfelor</td>
                      <td><p>09783746283</p><p>Globe</p></td>
                      <td><p>09783746283</p><p>Globe</p></td>
                      <td><button>Delete</button></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
            </div>
          </div>
        </div>
        <div class='Modal-Sidebar-Bottom'>
          <button class='Btn_1' onclick='PromptDoctor(`UpdateDoctor`,`".$row['doctor_account_id']."`)'>Save</button>
          <button class='Btn_2' onclick='BackToViewDoctor()'>Cancel</button>
        </div>
      ";
    };
  } else {
    echo "No Data Found";
  }
}


// SEARCH
if (isset($_POST["searchId"])) {
  global $connMysqli;
  $searchId = $_POST["searchId"];
  $searchName = $_POST["searchName"];

  if($searchId == 1){
    $DoctorSpecsFetchQuery = "SELECT * from specialization
    WHERE specialization_name LIKE '%$searchName%' 
    ";
    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorSpecsFetchQuery->num_rows > 0) {
      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {echo" 
        <li onclick='selectThis(`Specs`,".$SpecsRow['specialization_id'].",`Specs1`)'><i class='fa-solid fa-plus'></i> <p>".$SpecsRow['specialization_name']."</p></li>
        ";
      }
    }
    else{
      echo "Nothing Found!";
    }
  }
  elseif($searchId == 2){
    $DoctorSpecsFetchQuery = "SELECT * from sub_specialization
    WHERE sub_specialization_name LIKE '%$searchName%' 
    ";
    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorSpecsFetchQuery->num_rows > 0) {
      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {echo" 
        <li onclick='selectThis(`SubSpecs`,".$SpecsRow['sub_specialization_id'].",`Specs1`)'><i class='fa-solid fa-plus'></i> <p>".$SpecsRow['sub_specialization_name']."</p></li>
        ";
      }
    }
    else{
      echo "Nothing Found!";
    }
  }
  elseif($searchId == 3){
    $DoctorSpecsFetchQuery = "SELECT * from room
    WHERE room_floor_name LIKE '%$searchName%' 
    ";
    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorSpecsFetchQuery->num_rows > 0) {
      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {echo" 
        <li onclick='selectThis(`Room`,".$SpecsRow['room_id'].",`Specs1`)'><i class='fa-solid fa-plus'></i> <p>".$SpecsRow['room_floor_name']."</p></li>
        ";
      }
    }
    else{
      echo "Nothing Found!";
    }
  }
  elseif($searchId == 4){
    $DoctorSpecsFetchQuery = "SELECT * from hmo
    WHERE hmo_name LIKE '%$searchName%' 
    ";
    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorSpecsFetchQuery->num_rows > 0) {
      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {echo" 
        <li onclick='selectThis(`HMO`,".$SpecsRow['hmo_id'].",`Specs1`)'><i class='fa-solid fa-plus'></i> <p>".$SpecsRow['hmo_name']."</p></li>
        ";
      }
    }
    else{
      echo "Nothing Found!";
    }
  }

}


// SELECT SPECS
if (isset($_POST["functionSelectedItems"])) {
  global $connMysqli;
  $functionSelectedArrayItems = $_POST["functionSelectedItems"];

  if (!empty($functionSelectedArrayItems) && is_array($functionSelectedArrayItems)) {
    $ids = implode(",", array_map('intval', $functionSelectedArrayItems));
    $DoctorSpecsFetchQuery = "SELECT * FROM specialization WHERE specialization_id IN ($ids)";
    // echo $DoctorSpecsFetchQuery; 

    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorSpecsFetchQuery->num_rows > 0) {
      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {echo" 
        <p>".$SpecsRow['specialization_name']."</p>
        ";
      }
    }
    else{
      echo "Nothing Found!";
    }
  } else {
      echo "No valid items selected.";
  }
}


// SELECT SUB SPECS
if (isset($_POST["functionSelectedItems2"])) {
  global $connMysqli;
  $functionSelectedArrayItems = $_POST["functionSelectedItems2"];

  if (!empty($functionSelectedArrayItems) && is_array($functionSelectedArrayItems)) {
    $ids = implode(",", array_map('intval', $functionSelectedArrayItems));
    $DoctorSpecsFetchQuery = "SELECT * FROM sub_specialization WHERE sub_specialization_id IN ($ids)";
    // echo $DoctorSpecsFetchQuery; 

    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorSpecsFetchQuery->num_rows > 0) {
      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {echo" 
        <p>".$SpecsRow['sub_specialization_name']."</p>
        ";
      }
    }
    else{
      echo "Nothing Found!";
    }
  } else {
      echo "No valid items selected.";
  }
}

// SELECT ROOM
if (isset($_POST["functionSelectedItems3"])) {
  global $connMysqli;
  $functionSelectedArrayItems = $_POST["functionSelectedItems3"];

  if (!empty($functionSelectedArrayItems) && is_array($functionSelectedArrayItems)) {
    $ids = implode(",", array_map('intval', $functionSelectedArrayItems));
    $DoctorSpecsFetchQuery = "SELECT * FROM room WHERE room_id IN ($ids)";
    // echo $DoctorSpecsFetchQuery; 

    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorSpecsFetchQuery->num_rows > 0) {
      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {echo" 
        <p>".$SpecsRow['room_floor_name']."</p>
        ";
      }
    }
    else{
      echo "Nothing Found!";
    }
  } else {
      echo "No valid items selected.";
  }
}


// SELECT HMO 
if (isset($_POST["functionSelectedItems4"])) {
  global $connMysqli;
  $functionSelectedArrayItems = $_POST["functionSelectedItems4"];

  if (!empty($functionSelectedArrayItems) && is_array($functionSelectedArrayItems)) {
    $ids = implode(",", array_map('intval', $functionSelectedArrayItems));
    $DoctorSpecsFetchQuery = "SELECT * FROM hmo WHERE hmo_id IN ($ids)";
    // echo $DoctorSpecsFetchQuery; 

    $DoctorSpecsFetchQuery = mysqli_query($connMysqli, $DoctorSpecsFetchQuery);
    if (!$DoctorSpecsFetchQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
    if ($DoctorSpecsFetchQuery->num_rows > 0) {
      while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsFetchQuery)) {echo" 
        <p>".$SpecsRow['hmo_name']."</p>
        ";
      }
    }
    else{
      echo "Nothing Found!";
    }
  } else {
      echo "No valid items selected.";
  }
}


// ADD ITEMS DIV
if (isset($_POST["AddItemsItemType"])) {
  global $connMysqli;
  $AddItemsItemType = $_POST["AddItemsItemType"];

  if($AddItemsItemType == "Specs"){
    echo "
        <div class='Add-Items-Header'>
          <h3>Add Specialization</h3>
          <i class='fa-solid fa-xmark' onclick='CloseAddItems()'></i>
        </div>

        <div class='Add-Items-Content'>
          <div class='AddItemsForm'>
            <label for='AddName'>Name</label>
            <input type='text' id='InsertDataName'>
            <button onclick='InsertDocData(`Specs`)'>Insert</button>
          </div>
        </div>
        
        <div class='Add-Items-Message'></div>
    ";
  }
  elseif($AddItemsItemType == "SubSpecs"){
    echo "
        <div class='Add-Items-Header'>
          <h3>Add Sub Specialization</h3>
          <i class='fa-solid fa-xmark' onclick='CloseAddItems()'></i>
        </div>

        <div class='Add-Items-Content'>
          <div class='AddItemsForm'>
            <div class='Add-Items-Div'>
              <label for='AddName'>Specialization Name</label>
              <input type='text' id='InsertDataSpecsName' onkeyup='SearchAddSpecs(`InsertDataSpecsName`)'>
              <input type='hidden' id='InsertDataID'>

              <div class='Add-Items-List'>
                list
              </div>
            </div>
            <div class=''>
              <label for='AddName'>Sub Specialization Name</label>
              <input type='text' id='InsertDataName'>
            </div>
          </div>
          <br>
            <button onclick='InsertDocData(`SubSpecs`)'>Insert</button>
        </div>
        <div class='Add-Items-Message'></div>
    ";
  }
  elseif($AddItemsItemType == "HMO"){
    echo "
        <div class='Add-Items-Header'>
          <h3>Add HMO</h3>
          <i class='fa-solid fa-xmark' onclick='CloseAddItems()'></i>
        </div>

        <div class='Add-Items-Content'>
          <div class='AddItemsForm'>
            <label for='AddName'>Name</label>
            <input type='text' id='InsertDataName'>
            <button onclick='InsertDocData(`HMO`)'>Insert</button>
          </div>
        </div>
        <div class='Add-Items-Message'></div>
    ";
  }

  elseif($AddItemsItemType == "Room"){
    echo "
        <div class='Add-Items-Header'>
          <h3>Add Room</h3>
          <i class='fa-solid fa-xmark' onclick='CloseAddItems()'></i>
        </div>

        <div class='Add-Items-Content'>
          <div class='AddItemsForm'>
            <div class='Add-Items-Div'>
              <label for='AddName'>Floor Level</label>
              <input type='text' id='InsertDataFloorLevel'>
            </div>
            <div class=''>
              <label for='AddName'>Room Number</label>
              <input type='text' id='InsertDataRoomNumber'>
            </div>
          </div>
          <br>
            <button onclick='InsertDocData(`Room`)'>Insert</button>
        </div>
        <div class='Add-Items-Message'></div>
    ";
  }
}


// INSERT DATA ITEMS      
if (isset($_POST["InsertDocDataItemType"])) {
  global $connMysqli;
  $InsertDocDataItemType = $_POST["InsertDocDataItemType"];
  if($InsertDocDataItemType == "Room"){
    $InsertDocDataName = $_POST["InsertDocDataName"];
  }
  else if($InsertDocDataItemType == "SubSpecs"){
    $InsertDocDataName = $_POST["InsertDocDataName"];
    $InsertDocDataID = $_POST["InsertDocDataID"];
  }
  else{
    $InsertDocDataName = $_POST["InsertDocDataName"];
  }

  if($InsertDocDataName != ""){
    if($InsertDocDataItemType == "Specs"){
      $DoctorSpecsInsertQuery = "SELECT * FROM specialization WHERE specialization_name =  '$InsertDocDataName'";
      $DoctorSpecsInsertQuery = mysqli_query($connMysqli, $DoctorSpecsInsertQuery);
      if (!$DoctorSpecsInsertQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
      if ($DoctorSpecsInsertQuery->num_rows > 0) {
        
        echo "Already Existed!";
      }
      else{
        echo "Insert Successfully";
        $InsertDoctorSpecs = $connPDO->prepare("INSERT INTO `specialization`(specialization_name) VALUES(?)");
        $InsertDoctorSpecs->execute([$InsertDocDataName]);
      }
    }
    elseif($InsertDocDataItemType == "SubSpecs"){
      $DoctorSpecsInsertQuery = "SELECT * FROM sub_specialization WHERE sub_specialization_name =  '$InsertDocDataName'";
      $DoctorSpecsInsertQuery = mysqli_query($connMysqli, $DoctorSpecsInsertQuery);
      if (!$DoctorSpecsInsertQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
      if ($DoctorSpecsInsertQuery->num_rows > 0) {
        
        echo "Already Existed!";
      }
      else{
        echo "Insert Successfully";
        $InsertDoctorSpecs = $connPDO->prepare("INSERT INTO `sub_specialization`(sub_specs_id, sub_specialization_name) VALUES(?,?)");
        $InsertDoctorSpecs->execute([$InsertDocDataID, $InsertDocDataName]);
      }
    }
    elseif($InsertDocDataItemType == "HMO"){
      $DoctorSpecsInsertQuery = "SELECT * FROM hmo WHERE hmo_name =  '$InsertDocDataName'";
      $DoctorSpecsInsertQuery = mysqli_query($connMysqli, $DoctorSpecsInsertQuery);
      if (!$DoctorSpecsInsertQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
      if ($DoctorSpecsInsertQuery->num_rows > 0) {
        
        echo "Already Existed!";
      }
      else{
        echo "Insert Successfully";
        $InsertDoctorSpecs = $connPDO->prepare("INSERT INTO `hmo`(hmo_name) VALUES(?)");
        $InsertDoctorSpecs->execute([$InsertDocDataName]);
      }
    }
    elseif($InsertDocDataItemType == "Room"){
      // $InsertDataFloorLevel = $_POST["InsertDataFloorLevel"];
      // $InsertDataFloorNumber = $_POST["InsertDataFloorNumber"];
      // $InsertData = $InsertDataFloorLevel . " - " . $InsertDocDataName;
      $DoctorSpecsInsertQuery = "SELECT * FROM room WHERE room_floor_name =  '$InsertDocDataName'";
      $DoctorSpecsInsertQuery = mysqli_query($connMysqli, $DoctorSpecsInsertQuery);
      if (!$DoctorSpecsInsertQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
      if ($DoctorSpecsInsertQuery->num_rows > 0) {
        echo "Already Existed!";
      }
      else{
        echo "Insert Successfully";
        $InsertDoctorSpecs = $connPDO->prepare("INSERT INTO `room`(room_floor_name) VALUES(?)");
        $InsertDoctorSpecs->execute([$InsertDocDataName]);
      }
    }
  
  }
  else{
    echo "Input Text!";
  }
}


// SEARCH FOR SUB SPECS
if (isset($_POST["SearchAddSpecs"])) {
  global $connMysqli;
  $InsertDataSpecsName = $_POST["InsertDataSpecsName"];

  $DoctorSpecsInsertQuery = "SELECT * FROM specialization WHERE specialization_name LIKE '%$InsertDataSpecsName%' ";

  $DoctorSpecsInsertQuery = mysqli_query($connMysqli, $DoctorSpecsInsertQuery);
  if (!$DoctorSpecsInsertQuery) {die('MySQL ErrorL ' . mysqli_error($conn));}
  if ($DoctorSpecsInsertQuery->num_rows > 0) {
    while ($SpecsRow = mysqli_fetch_assoc($DoctorSpecsInsertQuery)) {echo" 
      <p onclick='selectThisAddSubSpecs(`".$SpecsRow['specialization_name']."`, `".$SpecsRow['specialization_id']."`)' >".$SpecsRow['specialization_name']."</p>
      ";
    }
  }
  else{
    echo "Nothing Found";
  }
}


// ADD SCHEDULE
if (isset($_POST["AddSchedule"])) {
  global $connMysqli;
  $AddSchedule = $_POST["AddSchedule"];
  $together = $_POST["together"];

  $arr = implode(",", $AddSchedule);
  foreach ($AddSchedule as $schedule) {
    echo "<p>" . htmlspecialchars($schedule) . "</p>";
  }
}



// UPDATE DOCTOR
if (isset($_POST["UpdateDoctorType"])) {
  global $connMysqli;
  $UpdateDoctorType = $_POST["UpdateDoctorType"];
  $DoctorID = $_POST["DoctorID"];

  if($UpdateDoctorType == "Delete"){
    $query = "UPDATE doctor SET 
    doctor_archive_status = 'HIDDEN'
    WHERE doctor_account_id  = '$DoctorID'";
    mysqli_query($connMysqli, $query);
    echo "Account Deactivated.";
  }

  elseif($UpdateDoctorType == "Restore"){
    $query = "UPDATE doctor SET 
    doctor_archive_status = 'VISIBLE'
    WHERE doctor_account_id  = '$DoctorID'";
    mysqli_query($connMysqli, $query);
    echo "Account Restored.";
  }

  // echo  $DoctorID;
}


















?>