var entityMap = {
   "&": "&amp;",
   "<": "&lt;",
   ">": "&gt;",
   '"': '&quot;',
   "'": '&#39;',
   "/": '&#x2F;'
 };

 function escapeHtml(string) {
   return String(string).replace(/[&<>"'\/]/g, function (s) {
	 return entityMap[s];
   });
 }

function getApercu() {
	var x = escapeHtml(document.getElementById("messageArea").value);
	document.getElementById("apercu").innerHTML = x;
}
