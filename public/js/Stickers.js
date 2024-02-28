let about, about2, about3, name, lastName, StickersLogo, choice, logoData;
document.getElementById("detector").addEventListener('keyup', doThing);
document.getElementById("detector").addEventListener('change', doThing);

        fetch("/StickersLogo/StickersLogo.json")
            .then(res => res.json())
            .then(data => logoData = data)
console.log(logoData);
 function doThing() {

         about = document.getElementById("fullNameDisplayed");
         about.style.fill = document.getElementById("textColor").value;
         name = document.getElementById("stickersName").value;
         lastName = document.getElementById("stickersLastName").value;
         name = name.replace(/\s+/g, '');
         lastName = lastName.replace(/\s+/g, '');
         about.innerHTML = name + " " + lastName;
         about2 = document.getElementById("stickers");
         about2.style.fill = document.getElementById("backColor").value;
         about3 = document.getElementById("StickersPicture");
         choice = document.getElementById("logoChoice").value;
         switch (Number(choice)){
                 case 1:
                         StickersLogo = logoData.logo1;
                         break;
                 case 2:
                         StickersLogo = logoData.logo2;
                         break;
                 case 3:
                         StickersLogo = logoData.logo3;
                         break;
                 default:
                         StickersLogo = logoData.logo0;
         }
         about3.setAttribute("href", "data:image/png;base64," + StickersLogo.replace(/\\+/g, ''));
 }