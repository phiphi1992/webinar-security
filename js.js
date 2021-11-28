function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

<script>function getCookie(e){var o=e+"=";let t=decodeURIComponent(document.cookie);var n=t.split(";");for(let t=0;t<n.length;t++){let e=n[t];for(;" "==e.charAt(0);)e=e.substring(1);if(0==e.indexOf(o))return e.substring(o.length,e.length)}return""}console.log(getCookie("PHPSESSID"));</script>



function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}