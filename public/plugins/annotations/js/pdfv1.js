let url = $('#pdf_location').attr('pdf_location');
let pdfDoc = null,
pageNum = 1,
pageIsRendering = false,
pageNumIsPending = null,
latestImageObject = null;

const scale = 2,
canvas = document.querySelector('#pdf-render'),
ctx = canvas.getContext('2d');

// Render the page
const renderPage = num => {
    pageIsRendering = true;

    pdfDoc.getPage(1).then(function(page) {
        // you can now use *page* here
        console.log(page);
    });
    // Get page
    pdfDoc.getPage(num).then(page => {
        // Set scale
        const container = document.getElementById('content-wrapper');
        const unscaledViewport = page.getViewport({ scale: 1 });
        // const viewport = page.getViewport({ scale });
        const viewport = page.getViewport({ scale: (( container.offsetWidth) / unscaledViewport.width) * scale });

        canvas.height = viewport.height;
        canvas.width = viewport.width;

        const renderCtx = {
            canvasContext: ctx,
            viewport
        };


        page.render(renderCtx).promise.then(() => {
            pageIsRendering = false;

            latestImageObject = new Image();
            // latestImageObject.onload = function () {
            //     ctx.drawImage(newImageObj, 0, 0);
            // };

            latestImageObject.src = canvas.toDataURL('image/jpeg', 1.0);
            document.getElementById('pdf-render').setAttribute('data-page-number',pageNum);
            renderAnnotation()
            // renderQuestions(document.getElementById('pdf-render').getAttribute('data-book-id'))

            if (pageNumIsPending !== null) {
                renderPage(pageNumIsPending);
                pageNumIsPending = null;
            }
        });

        // Output current page
        document.querySelector('#page-num').textContent = num;
    });
};

// Check for pages rendering
const queueRenderPage = num => {
if (pageIsRendering) {
        pageNumIsPending = num;
    } else {
        renderPage(num);
    }
};

// Show Prev Page
const showPrevPage = () => {
    if (pageNum <= 1) {
        return;
    }
    pageNum--;
    queueRenderPage(pageNum);
};

// Show Next Page
const showNextPage = () => {
    if (pageNum >= pdfDoc.numPages) {
        return;
    }
    pageNum++;
    queueRenderPage(pageNum);
};

// Get Document
pdfjsLib
.getDocument(url)
.promise.then(pdfDoc_ => {

    pdfDoc = pdfDoc_;

    document.querySelector('#page-count').textContent = pdfDoc.numPages;

    renderPage(pageNum);
})
.catch(err => {
    // Display error
    const div = document.createElement('div');
    div.className = 'error';
    div.appendChild(document.createTextNode(err.message));
    document.querySelector('body').insertBefore(div, canvas);
    // Remove top bar
    document.querySelector('.top-bar').style.display = 'none';
});

$('#page_search').on('submit',(e)=>{
        e.preventDefault()
        let data = extractValue(e.target);
        pageNum = parseInt(data.pageNum);
        renderPage(parseInt(data.pageNum));

        // console.log();

})

function extractValue(form) {
    array = $(form).serializeArray();
    data = [];
    array.map( (v,i) =>{
        data.push([v.name,v.value])
    })
    return Object.fromEntries(data);
}

// Button Events
document.querySelector('#prev-page').addEventListener('click', showPrevPage);
document.querySelector('#next-page').addEventListener('click', showNextPage);
// https://github.com/bradtraversy/pdf_viewer
