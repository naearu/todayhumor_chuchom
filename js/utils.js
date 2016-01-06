function _popup( url, w, h){
    if( !w ) w = 600;
    if( !h ) h = 350;
    var window_left = (screen.width-w)/2;
    var window_top = (screen.height-h)/2;
    window.open(url,w,'width='+w+',height='+h+',scrollbars=yes,status=no,top=' +window_top+',left='+window_left+'');
}