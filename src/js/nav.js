window.onclick = function (event) {
  if (event.target.matches('#dropbtn1')) {
    toggleDropdownContent("dropdown1");
    if (document.getElementById("dropdown2").classList.contains('show')) {
      document.getElementById("dropdown2").classList.remove('show');
    } else if (document.getElementById("dropdown3").classList.contains('show')) {
      document.getElementById("dropdown3").classList.remove('show');
    }
  } else if (event.target.matches('#dropbtn2')) {
    toggleDropdownContent("dropdown2");
    if (document.getElementById("dropdown1").classList.contains('show')) {
      document.getElementById("dropdown1").classList.remove('show');
    } else if (document.getElementById("dropdown3").classList.contains('show')) {
      document.getElementById("dropdown3").classList.remove('show');
    }
  } else if (event.target.matches('#dropbtn3') || event.target.matches('#dropbtn3-1')) {
    toggleDropdownContent("dropdown3");
    if (document.getElementById("dropdown1").classList.contains('show')) {
      document.getElementById("dropdown1").classList.remove('show');
    } else if (document.getElementById("dropdown2").classList.contains('show')) {
      document.getElementById("dropdown2").classList.remove('show');
    }
  } else {
    closeAllDropdowns();
  }
  function toggleDropdownContent(dropdownId) {
    var dropdown = document.getElementById(dropdownId);
    dropdown.classList.toggle("show");
  }

  function closeAllDropdowns() {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    for (var i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}