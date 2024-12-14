function LinkToLogout() {
  location.href = "../Admin - Panel/Logout.php";
}

function BTNDashboard() {
  $(".AdminDashboard").css("display", "flex");
  $(".AdminDashboard").siblings().css("display", "none");
  $(".SBFocus1").siblings().removeClass("Sidebar_Active");
  $(".SBFocus1").addClass("Sidebar_Active");
  updateChartData();
  updateChartData2();
}
function BTNDoctors() {
  $(".DoctorsDiv").css("display", "flex");
  $(".DoctorsDiv").siblings().css("display", "none");

  $(".SBFocus2").siblings().removeClass("Sidebar_Active");
  $(".SBFocus2").addClass("Sidebar_Active");
}
function BTNAccounts() {
  $(".AccountsDiv").css("display", "flex");
  $(".AccountsDiv").siblings().css("display", "none");

  $(".SBFocus3").siblings().removeClass("Sidebar_Active");
  $(".SBFocus3").addClass("Sidebar_Active");
}
function BTNActivity() {
  $(".ActivityLogs").css("display", "flex");
  $(".ActivityLogs").siblings().css("display", "none");

  $(".SBFocus4").siblings().removeClass("Sidebar_Active");
  $(".SBFocus4").addClass("Sidebar_Active");
}
function BTNArchive() {
  $(".ArchivesDiv").css("display", "flex");
  $(".ArchivesDiv").siblings().css("display", "none");

  $(".SBFocus5").siblings().removeClass("Sidebar_Active");
  $(".SBFocus5").addClass("Sidebar_Active");
}

function clearText() {
  $(".CT1").val("");
}



function editNav(navId){  
  $(".edit-nav" + navId).addClass("editNavActive").removeClass("editNavInactive") .siblings().removeClass("editNavActive") .addClass("editNavInactive");
  $(".editDoctor-Child" + navId).css({"display":"flex"}).siblings().css({"display":"none"});

}

// Dashboard Chart
var chart;
function FuncChart(data) {
  var inputChartName1 = $("#chartInputSpecs-Names1").val();
  var inputChartName2 = $("#chartInputSpecs-Names2").val();
  var inputChartName3 = $("#chartInputSpecs-Names3").val();
  var inputChartName4 = $("#chartInputSpecs-Names4").val();
  var inputChartName5 = $("#chartInputSpecs-Names5").val();

  var options = {
    series: [{ data: data }],
    chart: { type: "bar", height: 250, dropShadow: { enabled: true, top: 0, left: 0, blur: 2, opacity: 0.2 } },
    plotOptions: { bar: { borderRadius: 4, borderRadiusApplication: "end", horizontal: true } },
    fill: { colors: ["#318499"] },
    dataLabels: { enabled: false },
    labels: {
      show: true,
      rotate: -45,
      rotateAlways: false,
      hideOverlappingLabels: true,
      showDuplicates: false,
      trim: false,
      minHeight: undefined,
      maxHeight: 120,
    },
    xaxis: { categories: [inputChartName1, inputChartName2, inputChartName3, inputChartName4, inputChartName5] },
  };
  chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render();
}


var inputSpecsChart1 = $("#chartInputSpecs-IDs1").val();
var inputSpecsChart2 = $("#chartInputSpecs-IDs2").val();
var inputSpecsChart3 = $("#chartInputSpecs-IDs3").val();
var inputSpecsChart4 = $("#chartInputSpecs-IDs4").val();
var inputSpecsChart5 = $("#chartInputSpecs-IDs5").val();
function updateChartData() {
  var newData = [0, 0, 0, 0, 0];
  var newData2 = [inputSpecsChart1, inputSpecsChart2, inputSpecsChart3, inputSpecsChart4, inputSpecsChart5];
  chart.updateSeries([{ data: newData }]);
  chart.updateSeries([{ data: newData2 }]);
}

// var inputChart = $("#chartInput").val();
var initialData = [inputSpecsChart1, inputSpecsChart2, inputSpecsChart3, inputSpecsChart4, inputSpecsChart5];
FuncChart(initialData);



// Dashboard Chart 2
var chart2;
function FuncChart2(data) {
  var inputChartName1 = $("#chartInputHMO-Names1").val();
  var inputChartName2 = $("#chartInputHMO-Names2").val();
  var inputChartName3 = $("#chartInputHMO-Names3").val();
  var inputChartName4 = $("#chartInputHMO-Names4").val();
  var inputChartName5 = $("#chartInputHMO-Names5").val();

  var options = {
    series: [{ data: data }],
    chart: { type: "bar", height: 250, dropShadow: { enabled: true, top: 0, left: 0, blur: 2, opacity: 0.2 } },
    plotOptions: { bar: { borderRadius: 4, borderRadiusApplication: "end", horizontal: true } },
    fill: { colors: ["#318499"] },
    dataLabels: { enabled: false },
    labels: {
      show: true,
      rotate: -45,
      rotateAlways: false,
      hideOverlappingLabels: true,
      showDuplicates: false,
      trim: false,
      minHeight: undefined,
      maxHeight: 120,
      minWidth: 400,
    },
    xaxis: {
      categories: [
        inputChartName1,
        inputChartName2,
        inputChartName3,
        inputChartName4,
        inputChartName5,
      ],
    },
  };
  chart2 = new ApexCharts(document.querySelector("#chart2"), options);
  chart2.render();
}



var inputChart1 = $("#chartInputHMO-IDs1").val();
var inputChart2 = $("#chartInputHMO-IDs2").val();
var inputChart3 = $("#chartInputHMO-IDs3").val();
var inputChart4 = $("#chartInputHMO-IDs4").val();
var inputChart5 = $("#chartInputHMO-IDs5").val();

function updateChartData2() {
  var newData = [0, 0, 0, 0, 0];
  var newData2 = [inputChart1, inputChart2, inputChart3, inputChart4, inputChart5];
  chart2.updateSeries([{ data: newData }]);
  chart2.updateSeries([{ data: newData2 }]);
}
var initialData2 = [inputChart1, inputChart2, inputChart3, inputChart4, inputChart5];
FuncChart2(initialData2);









$(document).ready(function () {
  // POP UP MESSAGE / WELCOME ADMIN
  const myTimeout = setTimeout(timer2, 3000);
  function timer2() {
    $(".PopUp-Div").css("display", "none");
    $(".AddDoctorDiv").removeClass("PopUp-Div-Add");
  }

  // PAGINATION - LOAD DATA
  function loadData(page) {
    $.ajax({
      url: "../Components/Function_Admin.php",
      type: "POST",
      data: { page: page },
      success: function (response) {
        // console.log(response);
        $("#data-container").html(response);
      },
    });
  }
  loadData(1);
  $(document).on("click", ".pagination li a", function (e) {
    e.preventDefault();
    var page = $(this).attr("data-page");
    loadData(page);
  });

  // ADD DOCTOR
  $(".BtnAddDoctor").click(function () {
    $(".AddDoctorDiv").css("display", "flex");
  });

  // CLOSE ADD DOCTOR CONTAINER
  $(".Close-AddDoctorDiv").click(function () {
    $(".AddDoctorDivContainer").css("display", "flex");
    $(".AddDoctorDivContainer").addClass("AddDoctorDivContainerClosing");
    $(".AddDoctorDiv").addClass("AddDoctorDivClosing");
    const myTimeout = setTimeout(timer2, 900);
    function timer2() {
      $(".AddDoctorDiv").css("display", "none");
      $(".AddDoctorDivContainer").removeClass("AddDoctorDivContainerClosing");
      $(".AddDoctorDiv").removeClass("AddDoctorDivClosing");
    }
  });
});

// ============= AJAX =============
// HIDE MODAL
function ModalSidebarExit() {
  $(".Modal-Sidebar").css("display", "none");
}

// DOCTOR ==================================
// OPEN NEW DOCTOR - MODAL
function AddDoctor() {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-AddDoctor").css("display", "flex");
  $(".Modal-AddDoctor").siblings().css("display", "none");
  $(".Modal-Container").css("display", "flex");
}

// OPEN MODAL / VIEW DOCTOR DETAILS
function ViewDoctor(ViewDoctorType,ViewDoctor_ID) {
  var data = {
    ViewDoctorType: ViewDoctorType,
    ViewDoctor_ID: ViewDoctor_ID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      if(ViewDoctorType == "View" || ViewDoctorType == "ArchivedView"){
        $(".Modal-Sidebar").css("display", "flex");
        $(".Modal-Container").css("display", "flex");
        $(".Modal-ViewDoctor").css("display", "flex");
        $(".Modal-ViewDoctor").siblings().css("display", "none");
        $(".Modal-ViewDoctor").html(response);

        if(ViewDoctorType == "ArchivedView"){
          $(".Modal-Sidebar-Bottom").css("display", "none");
        }
      }
    },
  });
}

// OPEN MODAL / EDIT DOCTOR DETAILS
function EditDoctor(ViewEdit_ID) {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-EditDoctor").css("display", "flex");
  $(".Modal-EditDoctor").siblings().css("display", "none");

  selectedDoctorID = ViewEdit_ID;

  var data = {
    ViewEdit_ID: ViewEdit_ID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      $(".Modal-EditDoctor").html(response);
    },
  });
}

// BACK TO DOCTOR DETAILS
function BackToViewDoctor() {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-ViewDoctor").css("display", "flex");
  $(".Modal-ViewDoctor").siblings().css("display", "none");
}

// PROMPT MESSAGE / HIDE PROMPT MODAL
function HidePromptMessage() {
  $(".Prompt-Message").css("display", "none");
  $(".Prompt-AddNewDoctor").css("display", "none");
}

// PROMPT MESSAGE / ADD NEW DOCTOR
function AddNewDoctor() {
  var DocInput1 = $("#DoctorsFirstName").val();
  var DocInput2 = $("#DoctorsMiddleName").val();
  var DocInput3 = $("#DoctorsLastName").val();
  var DocInput4 = $("#DoctorGender").val();
  var DocInput5 = $("#DoctorCategory").val();
  if(DocInput1 != "" & DocInput3 != "" & DocInput4 != "" & DocInput5 != ""){
    $(".Prompt-Message").css("display", "flex");
    $(".Prompt-AddNewDoctor").css("display", "flex");
    $(".Prompt-AddNewDoctor").siblings().css("display", "none");
  }
}

// PROMPT MESSAGE / UPDATE DOCTOR
// function UpdateDoctor() {
//   $(".Prompt-Message").css("display", "flex");
//   $(".Prompt-UpdateDoctor").css("display", "flex");
//   $(".Prompt-UpdateDoctor").siblings().css("display", "none");
// }

// PROMPT MESSAGE / Prompt DOCTOR
let DoctorID = "";
function PromptDoctor(PromptType, Prompt_ID) {
  $(".Prompt-Message").css("display", "flex");
  $(".Prompt-" + PromptType).css("display", "flex");
  $(".Prompt-" + PromptType).siblings().css("display", "none");
  DoctorID = Prompt_ID;
}


// PROMPT MESSAGE / ADD ACCESS ACCOUNT
function AddNewAccess() {
  $(".Prompt-Message").css("display", "flex");
  $(".Prompt-AccessAccount").css("display", "flex");
  $(".Prompt-AccessAccount").siblings().css("display", "none");
}

// PROMPT MESSAGE / RESET PASSWORD - ADMIN
function ResetPasswordAdmin(ResetPasswordAdmin_ID) {
  $(".Prompt-Message").css("display", "flex");
  $(".Prompt-ResetAdminAccount").css("display", "flex");
  $(".Prompt-ResetAdminAccount").siblings().css("display", "none");
  var data = {
    ResetPasswordAdmin_ID: ResetPasswordAdmin_ID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      $(".Prompt-ResetAdminAccount").html(response);
      // console.log(response);
    },
  });
}





// ACCOUNT ==================================
// OPEN NEW ADMIN - MODAL
function AddAdmin() {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-AddAdmin").css("display", "flex");
  $(".Modal-AddAdmin").siblings().css("display", "none");
}

// INSERT NEW DOCTOR
function PopMessages(PopMsg) {
  $("#Pop-Message").html(PopMsg);
  $(".Prompt-Message").css("display", "none");
  $(".PopUp-Message").css("display", "flex");
  $(".PopUp-Message").addClass("AddPopUp-Message");
  $(".Modal-Sidebar").css("display", "none");
  const myTimeout = setTimeout(timer2, 3000);
  function timer2() {
    $(".PopUp-Message").css("display", "none");
  }
}


// INSERT NEW DOCTOR
function InsertNewDoctor(InsertDoctor) {
  var data = {
    InsertDoctor: InsertDoctor,
    LastName: $("#DoctorsLastName").val(),
    MiddleName: $("#DoctorsMiddleName").val(),
    FirstName: $("#DoctorsFirstName").val(),
    Gender: $("#DoctorGender").val(),
    Specialization: selectedIds,
    SubSpecialization: selectedIds2,
    Schedule: scheduleArr,
    Secretary: secretaryArr,
    Remarks: $("#DoctorsRemarks").val(),
    Room: roomArr,
    HMOAccreditation: hmoArr,
    TeleConsultation: $("#DoctorsTeleConsult").val(),
    UserID: UserID,

    Category: $("#DoctorCategory").val(),
    PrimarySecretary: $("#DoctorsFirstName").val(),
    PrimaryFirstNumber: $("#DoctorsFirstName").val(),
    PrimaryFirstNetwork: $("#DoctorsFirstName").val(),
    PrimarySecondNumber: $("#DoctorsFirstName").val(),
    PrimarySecondNetwork: $("#DoctorsFirstName").val(),
    SecondarySecretary: $("#DoctorsFirstName").val(),
    SecondarySecondNumber: $("#DoctorsFirstName").val(),
    SecondarySecondNetwork: $("#DoctorsFirstName").val(),
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      reloadDiv('account_table');
      $(".Modal-Container").css("display", "none");
      $(".hiddenContainer").css("display", "none");
      clearText();
      if(response == "Doctor have been successfully inserted!"){
        PopMessages(response);
      }
    },
  });

  selectedIds.splice(0, selectedIds.length);
  selectedIds2.splice(0, selectedIds2.length);
  scheduleArr.splice(0, scheduleArr.length);
  secretaryArr.splice(0, secretaryArr.length);
  roomArr.splice(0, roomArr.length);
  hmoArr.splice(0, hmoArr.length);
  
  $("#hiddenInformationFieldIDSpecs").html("");
  $("#hiddenInformationFieldIDSpecs2").html("");

  $("#hiddenInformationFieldIDSubSpecs").html("");
  $("#DoctorsRemarks").val("");
  $("#day-select").val("Monday");
  $("#pick-timeIn").html("");
  $("#pick-timeOut").html("");
  $("#DoctorsRemarks").html("");


  $(".InformationFieldAddSchedule").html("");
  $(".InformationFieldAddSecretary").html("");
  $("#hiddenInformationFieldIDRoom").html("");
  $("#hiddenInformationFieldIDHMO").html("");
  $(".Prompt-Message").css("display","none");

}





function doctorSpecs(SearchSpecs){
  if($("#SpecializationInput").val() == ""){
    $(".HiddenInputFieldForm1").css("display", "none");
  }
  else{
    // $(".HiddenInputFieldForm1").css("display", "flex");
    var data = {
      SearchSpecs: SearchSpecs,
      SpecializationInput: $("#SpecializationInput").val(),
    };
    $.ajax({
      url: "../Components/Function_Admin.php",
      type: "post",
      data: data,
      success: function (response) {
        // console.log(response);
        $(".InformationField").html("response");
      },
    });
  }
}


function Yes_AddNewAccess(AccessAccount) {
  PopMessages();
  var data = {
    AccessAccount: AccessAccount,
    AccessUsername: $("#AccessUsername").val(),
    AccessType: $("#AccessType").val(),
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      reloadDiv('account_table')
      $("#Pop-Message").html("New Admin have been successfully added!");
    },
  });
}

function View_Admin(ViewAdmin_ID) {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-ViewAdmin").css("display", "flex");
  $(".Modal-Container").css("display", "flex");
  $(".Modal-ViewAdmin").siblings().css("display", "none");

  var data = {
    ViewAdmin_ID: ViewAdmin_ID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      $(".Modal-ViewAdmin").html(response);
      // console.log(response);
    },
  });
}


// OPEN MODAL / VIEW ADMIN
function ViewAdmin() {
  $(".Modal-Sidebar").css("display", "flex");
  $(".Modal-ViewAdmin").css("display", "flex");
  $(".Modal-Container").css("display", "flex");
  $(".Modal-ViewAdmin").siblings().css("display", "none");
}

function Yes_ResetPasswordAdmin(Yes_ResetPasswordAdmin_ID) {
  PopMessages();
  var data = {
    Yes_ResetPasswordAdmin_ID: Yes_ResetPasswordAdmin_ID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
    },
  });
}






// ADD DOCTOR - SEARCH
function editSearch(SearchType, searchId) {
  if(SearchType == "Insert"){
    const searchElement = $("#editSearch" + searchId);
    if (searchElement.val().length === 0) {
      searchElement.parent().siblings().css("display", "none");
    } else {
      searchElement.parent().siblings().css("display", "flex");
  
      var data = {
        searchId: searchId, 
        SearchType: SearchType, 
        searchName: $("#editSearch" + searchId).val(), 
      };
      $.ajax({
        url: "../Components/Function_Admin.php",
        type: "post",
        data: data,
        success: function (response) {
          // console.log(response);
          // console.log(searchId);
          $("#EditDropdown" + searchId).html(response);
        },
      });
    }
  }

  else if(SearchType == "Edit"){
    const searchElement = $("#edit_Search" + searchId);
    if (searchElement.val().length === 0) {
      searchElement.parent().siblings().css("display", "none");
    } else {
      searchElement.parent().siblings().css("display", "flex");
  
      var data = {
        searchId: searchId, 
        SearchType: SearchType, 
        searchName: $("#edit_Search" + searchId).val(), 
      };
      $.ajax({
        url: "../Components/Function_Admin.php",
        type: "post",
        data: data,
        success: function (response) {
          // console.log(response);
          // console.log(searchId);
          $("#Edit_Dropdown" + searchId).html(response);
        },
      });
    }


    console.log("Edit Type");
  }

}




const selectedIds = [];
const selectedIds2 = [];
const scheduleArr = [];
const secretaryArr = [];
const roomArr = [];
const hmoArr = [];
function selectThis(selectedType, selectedId, selectedCode) {
  const selectedElementId = $("#hiddenInformationFieldID" + selectedType);
  if (selectedType === "Specs") {
    selectedElementId.css("display", "flex");

    if (!selectedIds.includes(selectedId)) {
      selectedIds.push(selectedId);
    }  
    closeSearch(selectedId);
  
    selectedItems(selectedIds,selectedId,selectedCode);
    
    $("#editSearch1").val("");
    $(".hiddenContainer").css("display", "none");
  }

  else if(selectedType === "SubSpecs"){
    selectedElementId.css("display", "flex");

    if (!selectedIds2.includes(selectedId)) {
      selectedIds2.push(selectedId);
    }  
    closeSearch(selectedId);
  
    selectedItems2(selectedIds2);
    
    $("#editSearch2").val("");
    $(".hiddenContainer").css("display", "none");
  }
  else if(selectedType === "Room"){
    selectedElementId.css("display", "flex");

    if (!roomArr.includes(selectedId)) {
      roomArr.push(selectedId);
    }  
    closeSearch(selectedId);
  
    selectedItems3(roomArr);
    
    $("#editSearch3").val("");
    $(".hiddenContainer").css("display", "none");
  }
  else if(selectedType === "HMO"){
    selectedElementId.css("display", "flex");

    if (!hmoArr.includes(selectedId)) {
      hmoArr.push(selectedId);
    }  
    closeSearch(selectedId);
  
    selectedItems4(hmoArr);
    
    $("#editSearch4").val("");
    $(".hiddenContainer").css("display", "none");
  }




  else if(selectedType === "EditSpecs"){

  }


}


// CLOSE DOCTOR - SEARCH
function closeSearch(closeId) {
  const searchElement = $("#editSearch" + closeId);
  searchElement.val("");
  searchElement.parent().siblings().css("display", "none");
}

let selectedDoctorID = "";
function selectedItems(selectedIds,selectedId,selectedCode){
  console.log("Doctor ID: " + selectedDoctorID);
  var data = {
    functionSelectedItems: selectedIds,
    selectedId: selectedId,
    selectedCode: selectedCode,
    selectedDoctorID: selectedDoctorID,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      if(selectedCode === "InsertEditSpecs"){
        
      }
      else{
        $("#hiddenInformationFieldIDSpecs").html(response);
      }
    },
  });
}

function selectedItems2(selectedIds){
  // console.log(selectedIds);
  var data = {
    functionSelectedItems2: selectedIds,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      $("#hiddenInformationFieldIDSubSpecs").html(response);
    },
  });
}

function selectedItems3(selectedIds){
  // console.log(selectedIds);
  var data = {
    functionSelectedItems3: selectedIds,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      $("#hiddenInformationFieldIDRoom").html(response);
    },
  });
}

function selectedItems4(selectedIds){
  // console.log(selectedIds);
  var data = {
    functionSelectedItems4: selectedIds,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      $("#hiddenInformationFieldIDHMO").html(response);
    },
  });
}





function AddItems(ItemType){
  var data = {
    AddItemsItemType: ItemType,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
    $(".Add-Items-Container").css("display", "flex");
      $(".Add-Items-Container").html(response);
    },
  });
}



function InsertDocData(ItemType){
  if(ItemType == "Room"){
    const InsertDataFloorLevel = $("#InsertDataFloorLevel").val();
    const InsertDataFloorNumber = $("#InsertDataRoomNumber").val();
    InsertDocDataName = InsertDataFloorLevel + " - " + InsertDataFloorNumber;
  }
  else{
    InsertDocDataName =  $("#InsertDataName").val();
  }
  var data = {
    InsertDocDataItemType: ItemType,
    InsertDocDataName: InsertDocDataName,
    InsertDocDataID: $("#InsertDataID").val(),
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      $("#InsertDataName").val("");
      $(".Add-Items-Message").css("display", "flex");
      $(".Add-Items-Message").html(response);

      const myTimeout = setTimeout(timer2, 3000);
      function timer2() {
        $(".Add-Items-Message").css("display", "none");
      }
    },
  });
}

function CloseAddItems(){
  $(".Add-Items-Container").css("display", "none");
}


function SearchAddSpecs(InsertDataSpecsName){
  var data = {
    SearchAddSpecs: InsertDataSpecsName,
    InsertDataSpecsName: $("#InsertDataSpecsName" ).val(),
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);

    // $("#InsertDataName").val("");
    $(".Add-Items-List").css("display", "flex");
    $(".Add-Items-List").html(response);
    },
  });
}







function selectThisAddSubSpecs(selectThisAddSubSpecsName,selectThisAddSubSpecsID){
  $("#InsertDataSpecsName").val(selectThisAddSubSpecsName);
  $("#InsertDataID").val(selectThisAddSubSpecsID);
  $(".Add-Items-List").css("display", "none");
}





function AddSchedule() {
  const addDay = $("#day-select").val();
  const addIn = $("#pick-timeIn").val();
  const addOut = $("#pick-timeOut").val();
  if (!addDay || !addIn || !addOut) {
    console.error("Please select all fields before adding to the schedule.");
    return;
  }
  const formattedIn = formatTime(addIn);
  const formattedOut = formatTime(addOut);

  const together = `${addDay}, ${formattedIn} - ${formattedOut}`;

  if (!scheduleArr.includes(together)) {
    scheduleArr.push(together);
    // console.log("Schedule added:", together);
  } else {
    // console.warn("This schedule already exists:", together);
  }

  var data = {
    AddSchedule: scheduleArr,
    together: together,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      $(".InformationFieldAddSchedule").html(response);
    },
  });
}

function formatTime(time) {
  const [hours, minutes] = time.split(":");
  const period = hours >= 12 ? "PM" : "AM";
  const formattedHours = hours % 12 || 12; 
  return `${formattedHours}:${minutes}${period}`;
}


function AddSecretary() {
  const DoctorsSecretaryName = $("#DoctorsSecretaryName").val();
  const SecretaryMobile1 = $("#SecretaryMobile1").val();
  const SecretaryMobile2 = $("#SecretaryMobile2").val();
  const selectNetwork1 = $("#selectNetwork1").val();
  const selectNetwork2 = $("#selectNetwork2").val();

  const formattedMobile1 = `'${SecretaryMobile1}'`; 
  const formattedMobile2 = `'${SecretaryMobile2}'`; 

  const secretaryObject = {
    name: DoctorsSecretaryName,
    number: SecretaryMobile1,
    number2: SecretaryMobile2,
    network: selectNetwork1,
    network2: selectNetwork2,
  };

  const exists = secretaryArr.some(
    (item) =>
      item.name === secretaryObject.name &&
      item.number === secretaryObject.number &&
      item.network === secretaryObject.network &&
      item.number2 === secretaryObject.number2 &&
      item.network2 === secretaryObject.network2
  );

  if (!exists) {
    secretaryArr.push(secretaryObject);
  } else {
    console.warn("This Secretary already exists:", secretaryObject);
  }
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: { AddSecretary: secretaryArr },
    success: function (response) {
      // console.log(response);
      $(".InformationFieldAddSecretary").html(response);

      $("#DoctorsSecretaryName").val("");
      $("#SecretaryMobile1").val("");
      $("#SecretaryMobile2").val("");
      $("#selectNetwork1").val("-");
      $("#selectNetwork2").val("-");
    },
  });
}




function UpdateDoctorDB(UpdateType, DoctorID){
  var EditLastname = $("#EditLastName").val();
  var EditFirstname = $("#EditFirstName").val();
  var EditMiddlename = $("#EditMiddleName").val();
  var EditGender = $("#EditGender").val();
  var EditCategory = $("#EditCategory").val();
  var data = {
    UpdateDoctorType: UpdateType,
    DoctorID: DoctorID,
    UserID: UserID,
    EditLastname: EditLastname,
    EditFirstname: EditFirstname,
    EditMiddlename: EditMiddlename,
    EditGender: EditGender,
    EditCategory: EditCategory,
  };
  $.ajax({
    url: "../Components/Function_Admin.php",
    type: "post",
    data: data,
    success: function (response) {
      console.log(response);
      PopMessages(response)
      $(".tbody-doctor").load(location.href + " .tr-doctor");
      $(".tbody-archived").load(location.href + " .tr-archived");
      reloadDiv('UpdateDiv');
    },
  });
}


function reloadDiv(UpdateDiv){
  $(".tbody-doctor").load(location.href + " .tr-doctor");
  $(".tbodyActivityLogs").load(location.href + " .tr-ActivityLogs");
  $(".tbody-archived").load(location.href + " .tr-archived");
  $(".account-tbody").load(location.href + " .account-tr");

  $("#DashCount1").load(location.href + " #DashCount-1");
  $("#DashCount2").load(location.href + " #DashCount-2");
  $("#DashCount3").load(location.href + " #DashCount-3");
  $("#DashCount4").load(location.href + " #DashCount-4");
  $("#DashCount5").load(location.href + " #DashCount-5");
  $("#DashCount6").load(location.href + " #DashCount-6");
  $("#DashCount7").load(location.href + " #DashCount-7");

  // console.log(UpdateDiv);
  // $("#DIV").load(location.href + " #DashCount-7");
}

