	var resQ=1;
	
function SpiderCatHttpReq()
{
	var httpRequest = createHttpRequest();
	var resultId = '';

	function createHttpRequest()
	{
		var httpRequest;
		var browser = navigator.appName;

		if (browser == "Microsoft Internet Explorer")
		{
			httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}
		else
		{
			httpRequest = new XMLHttpRequest();
		}

		return httpRequest;
	}

	this.sendRequest=function(file, _resultId, txt)
	{
		resultId = _resultId;

	httpRequest.open('post', file, true);
		
		httpRequest.onreadystatechange = getRequest;

	httpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf8");

		httpRequest.send(txt);
	}

	function getRequest()
	{
		if (httpRequest.readyState == 4)
		{
		 if(resultId!='')
			document.getElementById(resultId).innerHTML = httpRequest.responseText;
		resQ=1;
		}
	}
}

var SCHR=new SpiderCatHttpReq();

function prod_change_picture(url,obj,width,height)
{
		
	phpurl=document.getElementById("prod_main_picture").style.backgroundImage.substr(0,document.getElementById("prod_main_picture").style.backgroundImage.indexOf("picture.php?url"));
	document.getElementById("prod_main_picture_a").href=obj.parentNode.href;
	
	document.getElementById("prod_main_picture").style.backgroundImage=phpurl+'picture.php?url='+url+'&width='+width+'&height='+height+'&reverse=1)';
	
}


function vote(vote_value,prid,div_id,rated_text,home___)
{  
	if(resQ)   
		{  
			resQ=0;
			
		paramslist=home___+'&product_id='+prid+'&vote_value='+vote_value+'&format=row';  
		  
		SCHR.sendRequest(home___, div_id ,paramslist);	
		
		document.getElementById(div_id).innerHTML='<div style="text-align:center;">'+rated_text+'</div>';  
		
		}  		
			
		
}


function submit_reveiw(text1,text2,text3)
{  
if(document.getElementById("full_name").value=='')      
{              
alert(text1);  	 	      
document.getElementById("full_name").focus();  	 	    
}        
else  
if(document.getElementById("message_text").value=='')      
{              
alert(text2);   	 	      
document.getElementById("message_text").focus();
}       
else  
{
	if(resQ) 
		{
			resQ=0;
  	  		SCHR.sendRequest(document.getElementById('wd_captcha_img').src.split("?")[0]+'?checkcap=1&cap_code='+document.getElementById("review_capcode").value, 'caphid','');
			resNumberOfTry=0;
			submitReveiwInner(text3);
		}

} 

}

function submitReveiwInner(text)
{
	if(resQ) 
		{
			if(document.getElementById("caphid").innerHTML=="1")
				document.forms['review'].submit();   
			else
				{
					alert(text);
					refreshCaptcha();
				}
		}   
else if(resNumberOfTry<100) setTimeout("submitReveiwInner('"+text+"');",200); resNumberOfTry++;

}

function refreshCaptcha()
{
document.getElementById('wd_captcha_img').src=document.getElementById('wd_captcha_img').src.split("?")[0]+'?r='+Math.floor(Math.random()*100);
document.getElementById("review_capcode").value='';
}

function cat_form_reset(form)
{
form.prod_name.value='';
if(typeof(form.cat_id)!=='undefined') form.cat_id.value='0';
form.submit();
}