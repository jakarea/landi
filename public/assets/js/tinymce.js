function darkFunction() {
  tinymce.init({
    selector: '#description',
    plugins: 'powerpaste casechange searchreplace autolink directionality advcode visualblocks visualchars image link media mediaembed codesample table charmap pagebreak nonbreaking anchor tableofcontents insertdatetime advlist lists checklist wordcount tinymcespellchecker editimage help formatpainter permanentpen charmap linkchecker emoticons advtable export autosave',
    toolbar: 'undo redo print spellcheckdialog formatpainter | blocks fontfamily fontsize | bold italic underline forecolor backcolor | link image | alignleft aligncenter alignright alignjustify lineheight | checklist bullist numlist indent outdent | removeformat',
    height: '300px',
    skin: "oxide-dark",
    content_css: "dark",
    apiKey: 'qmijgms39dmc06urbtcpbgq3h84ylgnbzsup0df61hg3mwd0',

  });
}
function lightFunction() {
  tinymce.init({
    selector: '#description',
    plugins: 'powerpaste casechange searchreplace autolink directionality advcode visualblocks visualchars image link media mediaembed codesample table charmap pagebreak nonbreaking anchor tableofcontents insertdatetime advlist lists checklist wordcount tinymcespellchecker editimage help formatpainter permanentpen charmap linkchecker emoticons advtable export autosave',
    toolbar: 'undo redo print spellcheckdialog formatpainter | blocks fontfamily fontsize | bold italic underline forecolor backcolor | link image | alignleft aligncenter alignright alignjustify lineheight | checklist bullist numlist indent outdent | removeformat',
    height: '300px',
    skin: "oxide",
    content_css: "default",
    apiKey: 'qmijgms39dmc06urbtcpbgq3h84ylgnbzsup0df61hg3mwd0',

  });
}