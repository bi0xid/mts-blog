
GB_myShow = function(caption, url, /* optional */ height, width, callback_fn) {
    var options = {
        caption: 'Affiliate Training Videos Presentation',
        height: height || 520,
        width: width || 660,
	  center_win:true,
        fullscreen: false,
        show_loading: false,
        callback_fn: callback_fn
    }
    var win = new GB_Window(options);
    return win.show(url);
}