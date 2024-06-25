//telefone
const handlePhone = (event) => {
   let input = event.target
   input.value = phoneMask(input.value)
 }
 
 const phoneMask = (value) => {
   if (!value) return ""
   value = value.replace(/\D/g,'')
   value = value.replace(/(\d{2})(\d)/,"($1) $2")
   value = value.replace(/(\d)(\d{4})$/,"$1-$2")
   return value
 }
//valores
 function k(i) {
   var v = i.value.replace(/\D/g,'');
   v = (v/100).toFixed(2) + '';
   v = v.replace(".", ",");
   v = v.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
   i.value = v;
}

//cnpj
document.getElementById('cnpj').addEventListener('input', function (e) {
 var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,3})(\d{0,3})(\d{0,4})(\d{0,2})/);
 e.target.value = !x[2] ? x[1] : x[1] + '.' + x[2] + '.' + x[3] + '/' + x[4] + (x[5] ? '-' + x[5] : '');
});


//cpf
function mascara_cpf() {
 var cpf = document.getElementById('cpf')
 if(cpf.value.length == 3 || cpf.value.length == 7 ) {
     cpf.value += "."
 } else if(cpf.value.length == 11) {
     cpf.value += "-"
 }
}

//cep
function mascara_cep() {
   var cep = document.getElementById('cep')
   if(cep.value.length == 5) {
      cep.value += "-"
   } 
}