
// Disable workers to avoid yet another cross-origin issue (workers need the URL of
// the script to be loaded, and currently do not allow cross-origin scripts)
PDFJS.disableWorker = false;

var pdfDoc = null,
    pageNum = 1,
    scale = 0.8,
    canvas = document.getElementById('presentation'),
    ctx = canvas.getContext('2d');

// Get page info from document, resize canvas accordingly, and render page
function renderPage(num) {
  // Using promise to fetch the page
  pdfDoc.getPage(num).then(function(page) {
    var viewport = page.getViewport(scale);
    canvas.height = viewport.height;
    canvas.width = viewport.width;


    // Render PDF page into canvas context
    var renderContext = {
      canvasContext: ctx,
      viewport: viewport
    };
    page.render(renderContext);
  });
}

// Asynchronously download PDF as an ArrayBuffer
PDFJS.getDocument(url).then(function getPdfHelloWorld(_pdfDoc) {
  pdfDoc = _pdfDoc;
  renderPage(pageNum);
});