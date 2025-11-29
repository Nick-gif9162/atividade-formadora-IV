const btnGenerate = document.querySelector("#gerar-pdf");

btnGenerate.addEventListener("click", () => {
   const content = document.querySelector("#content");
const options = {
  margin:       [10, 10, 10, 10],
  filename:     'consultas.pdf',
  html2canvas:  { scale: 2 },
  jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
};
html2pdf().set(options).from(content).save();
});