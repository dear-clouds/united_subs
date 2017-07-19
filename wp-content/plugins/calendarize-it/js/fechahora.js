//Planilla Panama
function getCursorPos(inp){
    // for mozilla
	if( 'selectionEnd' in inp )
		return inp.selectionEnd;
    // for IE
    if(inp.createTextRange){
      var docrange = document.selection.createRange();
      var inprange = inp.createTextRange();
      inprange.setEndPoint('EndToStart', docrange);
      return inprange.text.length;
    }
	if(inp && inp.value && inp.value.length)
    	return inp.value.length; 
	return 0;
}

function setCursorPos(inp,pos){
    // for mozilla
    if('selectionStart' in inp) {
      inp.selectionStart = inp.selectionEnd = pos;
    }
    // for IE
    else if(inp.createTextRange) {
      var docrange = document.selection.createRange();
      var inprange = inp.createTextRange();
      inprange.move('character',pos);
      inprange.select();
    }
}

function validDate(obj,_key){
 date=obj.value;
 _pos = getCursorPos(obj);

switch(_key)
{	
	case 9:
	setCursorPos (obj, 0);
	return;
	
	case 8:
	case 37:
	case 39:
	return;
	
	case 38:
	case 40:
		date = scrollDate(date,_pos, _key);
		break;
}

if (/[^\d-]|(--)/g.test(date))  {
	obj.value=obj.value.replace(/[^\d-]/g,'');obj.value=obj.value.replace(/-{2}/g,'-'); 
	setCursorPos (obj, _pos-1);
	return;
}
if(/^\d{1}$/.test(date) && date>3){	date=obj.value+'-';}
if (/^\d{2}$/.test(date)){obj.value=obj.value+'-'; return; }
if (/^\d{1,2}-\d{1}$/.test(date) && date.substring(date.length-1,date.length)>1 ){var time=new Date();_ano=time.getFullYear();date=obj.value+'-'+_ano;}
if (/^\d{1,2}-\d{2}$/.test(date)){var time=new Date();_ano=time.getFullYear();obj.value=obj.value+'-'+_ano; /*alert('3');*/return; }
if (!/^\d{2}-\d{2}-\d{4}$/.test(date)){
	date = forzarFormato(date);
	if(_pos==2||_pos==5)_pos=_pos+1;
}
	_diff = date.length-obj.value.length;
	if(_diff<0)_diff=0;
	_pos = _pos + _diff;
	obj.value = date;
	setCursorPos (obj, _pos);
	return true;
}

function scrollDate(_date,_pos,_key)
{

	dRe = new RegExp("^([0-9]{2})-([0-9]{2})-([0-9]*)$","i");
	_dMatch = _date.match(dRe);
	if(_dMatch!=null)
	{
		if(_key==38){
			_inc = -1;	
		}else{
			_inc = 1;
		}
		
		if(_pos<3)
		{
			_dia = _dMatch[1] - _inc;
			if(_dia<=0)_dia='31';
			if(_dia>31)_dia='01';
			if(_dia.toString().length==1){_dia = '0'+_dia;}
			_date = _dia + "-" + _dMatch[2] + "-" + _dMatch[3];
		}
		else if(_pos<6)
		{
			_mes = _dMatch[2] - _inc;
			if(_mes<1)_mes='12';
			if(_mes>12)_mes='01';
			if(_mes.toString().length==1){_mes = '0' + _mes;}
			_date = _dMatch[1] + "-" + _mes + "-" + _dMatch[3];
		}
		else
		{
			if(_dMatch[3].toString().length!=4 || _dMatch[3] < 2000 || _dMatch[3] > 2020){var time=new Date();_dMatch[3]=time.getFullYear();_inc=0;}
			_ano = _dMatch[3] - _inc;
			_date = _dMatch[1] + "-" + _dMatch[2] + "-" + _ano;
		}
	}
	return _date;
}

function forzarFormato(_date)
{
	dRE = new RegExp("^([0-9]*)","i"); 

	_dMatch = _date.match(dRE);
	if(_dMatch!=null){
		_rep = _dMatch[1].substring(0,2);
		if(_rep>31){_rep = '0' + _rep.substring(0,1);}
		if(_rep=='00'){_rep='01';}
		_date = _date.replace(dRE, _rep);
	}

	dRE = new RegExp("^([0-9]{1,2})-([0-9]*)","i");
	_dMatch = _date.match(dRE);
	if(_dMatch!=null){
		if(_dMatch[1].length==1){
			_dia = '0'+_dMatch[1];
		}else{
			_dia = _dMatch[1].substring(0,2);
		}
		_rep = _dia + "-" + _dMatch[2].substring(0,2) ;
		_date = _date.replace(dRE,_rep );
	}	

	dRE = new RegExp("^([0-9]{1,2})-([0-9]{1,2})-([0-9]*)","i");
	_dMatch = _date.match(dRE);
	if(_dMatch!=null){
		if(_dMatch[2].toString().length==1){
			_mes = '0'+_dMatch[2];
		}else{
			_mes = _dMatch[2].substring(0,2);
		}
		if(_mes>12){_mes = '0' + _mes.substring(0,1);}
		if(_mes<1){_mes='01';}
		_rep = _dMatch[1] + "-" +_mes + "-" + _dMatch[3].substring(0,4) ;
		_date = _date.replace(dRE,_rep );
	}	
	
	return _date;
}

function validTime(obj,_key){
	_tiempo=obj.value;
 	var _pos = getCursorPos(obj);
	switch(_key){	
		case 9:
			setCursorPos (obj, 0);
			return;
		case 8:
		case 37:
		case 39:
			return;
		case 38:
		case 40:
			_tiempo = scrollTiempo(_tiempo, _pos, _key);
			break;
	}

	if (/[^\d\s:apm]|(::)/i.test(_tiempo))  {
		obj.value=obj.value.replace(/[^\d\s:apm]/g,'');
		obj.value=obj.value.replace(/:{2}/g,':'); 
		obj.value=obj.value.replace(/\s{2}/g,' '); 
		setCursorPos (obj, _pos-1);
		return;
	}

	if(/^(\d{1})[\s]*([ap])$/i.test(_tiempo)){_tiempo = _tiempo.replace(/^(\d{1})[\s]*([ap])/i, '0$1:00 $2');}
	
	if(/^(\d{0,2})[^\d:]/g.test(_tiempo)){
		obj.value=_tiempo.replace(/^(\d{0,2})[^\d:]/g,'$1:');
		setCursorPos (obj, _pos-1);
		return;
	}
	
	if(/(.*):([ap])/gi.test(_tiempo))
	{
		mRE = new RegExp("(.*):([ap])","i");
		dMatch = _tiempo.match(mRE);
		if(dMatch!=null){
			_tiempo = dMatch[1].substring(0,2) + ':00 ' + dMatch[2];
			_tiempo = _tiempo.replace(/a/gi,'am');
			_tiempo = _tiempo.replace(/p/gi,'pm');			
		}
	}
//todo rtrim pm/am
	if(/([^:]*):([0-9]{0,1})([ap])/i.test(_tiempo))
	{
		mRE = new RegExp("([^:]*):([0-9]{0,1})([ap])","i");
		dMatch = _tiempo.match(mRE);	
		if(dMatch!=null)
		{
			_min = dMatch[2].substring(0,2);
			if(_min.toString().length==1)_min = _min + '0'; 
			_tiempo = dMatch[1].substring(0,2) + ':' + _min + ' ' + dMatch[3].substring(0,2);
		}
	}

	if (/^(\d{1,2}):(\d{1,2})[\s][^ap]/i.test(_tiempo)){
		_tiempo = _tiempo.replace(/^(\d{1,2}):(\d{1,2})[\s][^ap]/, '$1:$2 '); 
	}
	
	if(/(\d{1,2}):(\d{1,2})\s*([ap])(.*)$/gi.test(_tiempo))
	{
		_tiempo = _tiempo.replace(/(\d{1,2}):(\d{1,2})\s*([ap])(.*)$/gi, '$1:$2 $3');
		_tiempo = _tiempo.replace(/a[^m]?/gi,'am');
		_tiempo = _tiempo.replace(/p[^m]?/gi,'pm');
	}
	//rtrim hour
	if(/^(\d{2})[^:]:(.*)/g.test(_tiempo)){ _tiempo = _tiempo.replace(/^(\d{2})[^:]:(.*)/g, '$1:$2');}
	
	if(/^(\d{1})$/.test(_tiempo) && _tiempo>1){_tiempo = _tiempo.replace(/^(\d{1})$/, '0$1:');}
	if (/^\d{2}$/.test(_tiempo)){obj.value=obj.value+':'; return; }
	if (/^(\d{2})(\d{1})$/.test(_tiempo)){_tiempo = _tiempo.replace( /^(\d{2})(\d{1})$/,'$1:$2'); }
	if (/^(\d{1,2}):(\d{1})$/.test(_tiempo) && _tiempo.substring(_tiempo.length-1,_tiempo.length)>5 ){_tiempo= _tiempo.replace(/^(\d{1,2}):(\d{1})$/, '$1:0$2 ');}
	if (/^\d{1,2}:\d{2}$/.test(_tiempo)){obj.value=obj.value+' '; return; }
	/*
	if(!/^\d{2}:\d{2}(\s)*(am|pm)$/i.test(_tiempo)){
		
	}*/
	if(_key!=38 &&_key!=40){
		if(_pos==2||_pos==5)_pos=_pos+1;
	}
	
	_tiempo = forzarFormatoTiempo(_tiempo);
	_diff = _tiempo.length-obj.value.length;
	if(_diff<0)_diff=0;
	_pos = _pos + _diff;
	
	obj.value = _tiempo;
	setCursorPos (obj, _pos);
	return true;
}

function scrollTiempo(_tiempo, _pos, _key)
{
	sRE = new RegExp("^([0-9]{1,2}):([0-9]{2}) (am|pm)$", "i");
	_dMatch = _tiempo.match(sRE);
//alert('>'+_tiempo + '< >'+_dMatch+'<');
	if(_dMatch!=null)
	{
	
		if(_key==38){
			_inc = -1;	
		}else if(_key==40){
			_inc = 1;
		}else{_inc = 0;}
		
		if(_pos<3)
		{
			_tmp = _dMatch[1] - _inc;
			if(_tmp<=0)_tmp='12';
			if(_tmp>12)_tmp='01';
			if(_tmp.toString().length==1){_tmp = '0'+_tmp;}
			_tiempo = _tmp + ":" + _dMatch[2] + " " + _dMatch[3];
		}
		else if(_pos<6)
		{
			_tmp = _dMatch[2] - _inc;
			if(_tmp<0)_tmp='59';
			if(_tmp>59)_tmp='00';
			if(_tmp.toString().length==1){_tmp = '0'+_tmp;}
			_tiempo = _dMatch[1] + ":" + _tmp + " " + _dMatch[3];
		}
		else
		{
			_tmp = _dMatch[3];
			if(_tmp=='am'){_tmp='pm';}
			else{_tmp='am';}
			_tiempo = _dMatch[1] + ":" + _dMatch[2] + " " + _tmp;
		}
	}
	return _tiempo;
}

function forzarFormatoTiempo(_tiempo)
{
	
	if(/^([^:]{2})[^:]*:([^\s]{2})[^\s]*\s*(am|pm).*/i.test(_tiempo))
	{
		_tiempo = _tiempo.replace(/^([^:]{2})[^:]*:([^\s]{2})[^\s]*\s*(am|pm).*/i, '$1:$2 $3');
	}

	sRE = new RegExp("^([0-9]{2}):([0-9]{2}) (am|pm)$", "i");
	_dMatch = _tiempo.match(sRE);

	if(_dMatch!=null)
	{
	//alert(_hor);
		_hor = _dMatch[1];
		if(_hor<=0)_hor='12';
		if(_hor>12)_hor='01';
		_min = _dMatch[2];
		if(_min<0)_min='59';
		if(_min>59)_min='00';
		
		_tiempo = _hor + ':' + _min + ' ' + _dMatch[3];
	}
	
	return _tiempo;
}

function forzarFormatoTiempo2(_tiempo){
	if(/^([^:]{1,2})[^:]*:([^\s]{1,2})[^\s]*\s*(am|pm).*/i.test(_tiempo)){
		_tiempo = _tiempo.replace(/^([^:]{1,2})[^:]*:([^\s]{1,2})[^\s]*\s*(am|pm).*/i, '$1:$2 $3');
	}

	sRE = new RegExp("^([0-9]{1,2}):([0-9]{2}) (am|pm)$", "i");
	_dMatch = _tiempo.match(sRE);

	if(_dMatch!=null){
		_hor = _dMatch[1];
		if(_hor<=0)_hor='12';
		if(_hor>12)_hor='01';
		_min = _dMatch[2];
		if(_min<0)_min='59';
		if(_min>59)_min='00';
		
		_tiempo = padLeft(_hor,2,'0') + ':' + _min + ' ' + _dMatch[3];
		return _tiempo;
	}else{
		return '';
	}
}

function padLeft(s,len,c){
  c=c || '0';
  while(s.length< len) s= c+s;
  return s;
}

function hvalidDate(e,obj){
	if(!e)
		var e = window.event;
	key = e.keyCode;	
	return validDate(obj,key);
}

function hvalidTime(e,obj){
	if(!e)
		var e = window.event;
	key = e.keyCode;	
	return validTime(obj,key);
}