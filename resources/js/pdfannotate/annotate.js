import PDFJSAnnotate from 'pdf-annotate.js';
import _initColorPicker2 from './colorPicker';

var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

const { UI } = PDFJSAnnotate;

var documentId = '/example.pdf';
var PAGE_HEIGHT = void 0;
var RENDER_OPTIONS = {
  documentId: documentId,
  pdfDocument: null,
  scale: parseFloat(localStorage.getItem(documentId + '/scale'), 10) || 1.33,
  rotate: parseInt(localStorage.getItem(documentId + '/rotate'), 10) || 0
};

PDFJSAnnotate.setStoreAdapter(new PDFJSAnnotate.LocalStoreAdapter());
PDFJS.workerSrc = '/shared/pdf.worker.js';

	// Render stuff
	var NUM_PAGES = 0;
	document.getElementById('content-wrapper').addEventListener('scroll', function (e) {
	  var visiblePageNum = Math.round(e.target.scrollTop / PAGE_HEIGHT) + 1;
	  var visiblePage = document.querySelector('.page[data-page-number="' + visiblePageNum + '"][data-loaded="false"]');
	  if (visiblePage) {
	    setTimeout(function () {
	      UI.renderPage(visiblePageNum, RENDER_OPTIONS);
	    });
	  }
	});

	function render() {
	  PDFJS.getDocument(RENDER_OPTIONS.documentId).then(function (pdf) {
	    RENDER_OPTIONS.pdfDocument = pdf;

	    var viewer = document.getElementById('viewer');
	    viewer.innerHTML = '';
	    NUM_PAGES = pdf.pdfInfo.numPages;
	    for (var i = 0; i < NUM_PAGES; i++) {
	      var page = UI.createPage(i + 1);
	      viewer.appendChild(page);
	    }

	    UI.renderPage(1, RENDER_OPTIONS).then(function (_ref) {
	      var _ref2 = _slicedToArray(_ref, 2);

	      var pdfPage = _ref2[0];
	      var annotations = _ref2[1];

	      var viewport = pdfPage.getViewport(RENDER_OPTIONS.scale, RENDER_OPTIONS.rotate);
	      PAGE_HEIGHT = viewport.height;
	    });
	  });
	}
	render();

	// Text stuff
	(function () {
	  var textSize = void 0;
	  var textColor = void 0;

	  function initText() {
	    var size = document.querySelector('.toolbar .text-size');
	    [8, 9, 10, 11, 12, 14, 18, 24, 30, 36, 48, 60, 72, 96].forEach(function (s) {
	      size.appendChild(new Option(s, s));
	    });

	    setText(localStorage.getItem(RENDER_OPTIONS.documentId + '/text/size') || 10, localStorage.getItem(RENDER_OPTIONS.documentId + '/text/color') || '#000000');

	    (0, _initColorPicker2.default)(document.querySelector('.text-color'), textColor, function (value) {
	      setText(textSize, value);
	    });
	  }

	  function setText(size, color) {
	    var modified = false;

	    if (textSize !== size) {
	      modified = true;
	      textSize = size;
	      localStorage.setItem(RENDER_OPTIONS.documentId + '/text/size', textSize);
	      document.querySelector('.toolbar .text-size').value = textSize;
	    }

	    if (textColor !== color) {
	      modified = true;
	      textColor = color;
	      localStorage.setItem(RENDER_OPTIONS.documentId + '/text/color', textColor);

	      var selected = document.querySelector('.toolbar .text-color.color-selected');
	      if (selected) {
	        selected.classList.remove('color-selected');
	        selected.removeAttribute('aria-selected');
	      }

	      selected = document.querySelector('.toolbar .text-color[data-color="' + color + '"]');
	      if (selected) {
	        selected.classList.add('color-selected');
	        selected.setAttribute('aria-selected', true);
	      }
	    }

	    if (modified) {
	      UI.setText(textSize, textColor);
	    }
	  }

	  function handleTextSizeChange(e) {
	    setText(e.target.value, textColor);
	  }

	  document.querySelector('.toolbar .text-size').addEventListener('change', handleTextSizeChange);

	  initText();
	})();

	// Pen stuff
	(function () {
	  var penSize = void 0;
	  var penColor = void 0;

	  function initPen() {
	    var size = document.querySelector('.toolbar .pen-size');
	    for (var i = 0; i < 20; i++) {
	      size.appendChild(new Option(i + 1, i + 1));
	    }

	    setPen(localStorage.getItem(RENDER_OPTIONS.documentId + '/pen/size') || 1, localStorage.getItem(RENDER_OPTIONS.documentId + '/pen/color') || '#000000');

	    (0, _initColorPicker2.default)(document.querySelector('.pen-color'), penColor, function (value) {
	      setPen(penSize, value);
	    });
	  }

	  function setPen(size, color) {
	    var modified = false;

	    if (penSize !== size) {
	      modified = true;
	      penSize = size;
	      localStorage.setItem(RENDER_OPTIONS.documentId + '/pen/size', penSize);
	      document.querySelector('.toolbar .pen-size').value = penSize;
	    }

	    if (penColor !== color) {
	      modified = true;
	      penColor = color;
	      localStorage.setItem(RENDER_OPTIONS.documentId + '/pen/color', penColor);

	      var selected = document.querySelector('.toolbar .pen-color.color-selected');
	      if (selected) {
	        selected.classList.remove('color-selected');
	        selected.removeAttribute('aria-selected');
	      }

	      selected = document.querySelector('.toolbar .pen-color[data-color="' + color + '"]');
	      if (selected) {
	        selected.classList.add('color-selected');
	        selected.setAttribute('aria-selected', true);
	      }
	    }

	    if (modified) {
	      UI.setPen(penSize, penColor);
	    }
	  }

	  function handlePenSizeChange(e) {
	    setPen(e.target.value, penColor);
	  }

	  document.querySelector('.toolbar .pen-size').addEventListener('change', handlePenSizeChange);

	  initPen();
	})();

	// Toolbar buttons
	(function () {
	  var tooltype = localStorage.getItem(RENDER_OPTIONS.documentId + '/tooltype') || 'cursor';
	  if (tooltype) {
	    setActiveToolbarItem(tooltype, document.querySelector('.toolbar button[data-tooltype=' + tooltype + ']'));
	  }

	  function setActiveToolbarItem(type, button) {
	    var active = document.querySelector('.toolbar button.active');
	    if (active) {
	      active.classList.remove('active');

	      switch (tooltype) {
	        case 'cursor':
	          UI.disableEdit();
	          break;
	        case 'draw':
	          UI.disablePen();
	          break;
	        case 'text':
	          UI.disableText();
	          break;
	        case 'point':
	          UI.disablePoint();
	          break;
	        case 'area':
	        case 'highlight':
	        case 'strikeout':
	          UI.disableRect();
	          break;
	      }
	    }

	    if (button) {
	      button.classList.add('active');
	    }
	    if (tooltype !== type) {
	      localStorage.setItem(RENDER_OPTIONS.documentId + '/tooltype', type);
	    }
	    tooltype = type;

	    switch (type) {
	      case 'cursor':
	        UI.enableEdit();
	        break;
	      case 'draw':
	        UI.enablePen();
	        break;
	      case 'text':
	        UI.enableText();
	        break;
	      case 'point':
	        UI.enablePoint();
	        break;
	      case 'area':
	      case 'highlight':
	      case 'strikeout':
	        UI.enableRect(type);
	        break;
	    }
	  }

	  function handleToolbarClick(e) {
	    if (e.target.nodeName === 'BUTTON') {
	      setActiveToolbarItem(e.target.getAttribute('data-tooltype'), e.target);
	    }
	  }

	  document.querySelector('.toolbar').addEventListener('click', handleToolbarClick);
	})();

	// Scale/rotate
	(function () {
	  function setScaleRotate(scale, rotate) {
	    scale = parseFloat(scale, 10);
	    rotate = parseInt(rotate, 10);

	    if (RENDER_OPTIONS.scale !== scale || RENDER_OPTIONS.rotate !== rotate) {
	      RENDER_OPTIONS.scale = scale;
	      RENDER_OPTIONS.rotate = rotate;

	      localStorage.setItem(RENDER_OPTIONS.documentId + '/scale', RENDER_OPTIONS.scale);
	      localStorage.setItem(RENDER_OPTIONS.documentId + '/rotate', RENDER_OPTIONS.rotate % 360);

	      render();
	    }
	  }

	  function handleScaleChange(e) {
	    setScaleRotate(e.target.value, RENDER_OPTIONS.rotate);
	  }

	  function handleRotateCWClick() {
	    setScaleRotate(RENDER_OPTIONS.scale, RENDER_OPTIONS.rotate + 90);
	  }

	  function handleRotateCCWClick() {
	    setScaleRotate(RENDER_OPTIONS.scale, RENDER_OPTIONS.rotate - 90);
	  }

	  document.querySelector('.toolbar select.scale').value = RENDER_OPTIONS.scale;
	  document.querySelector('.toolbar select.scale').addEventListener('change', handleScaleChange);
	  document.querySelector('.toolbar .rotate-ccw').addEventListener('click', handleRotateCCWClick);
	  document.querySelector('.toolbar .rotate-cw').addEventListener('click', handleRotateCWClick);
	})();

	// Clear toolbar button
	(function () {
	  function handleClearClick(e) {
	    if (confirm('Are you sure you want to clear annotations?')) {
	      for (var i = 0; i < NUM_PAGES; i++) {
	        document.querySelector('div#pageContainer' + (i + 1) + ' svg.annotationLayer').innerHTML = '';
	      }

	      localStorage.removeItem(RENDER_OPTIONS.documentId + '/annotations');
	    }
	  }
	  document.querySelector('a.clear').addEventListener('click', handleClearClick);
	})();