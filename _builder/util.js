	
	function ShowSystemMessage(message)
	{
		messageContainer = document.getElementById("message_container");
		ResetMessage(messageContainer);
		if(messageContainer && messageContainer.style.display=="none")
		{
			messageContainer.style.display="inline";
		}
		messageLabel = document.getElementById("systemMessage");
		if(messageLabel)
			messageLabel.innerHTML = message;
	}
	var hideMsgInterval = null;
	var hideMsgCounter = 100;
	function HideSystemMessage()
	{
		messageContainer = document.getElementById("message_container");

		ResetMessage(messageContainer);
	}
	function ResetMessage(messageContainer)
	{
		if(messageContainer)
		{
			messageContainer.style.display="none";
			hideMsgCounter = 100;
			common.setOpacity(messageContainer,100);
			window.clearInterval(hideMsgInterval);
		}
	}
	function HideMsg()
	{
		messageContainer = document.getElementById("message_container");
		common.setOpacity(messageContainer,hideMsgCounter);
		hideMsgCounter -= 5;
		if(hideMsgCounter<0)
		{
			ResetMessage(messageContainer);
		}
	}
	
		
	function num_format()
	{
		var _newval = this.value; 
		for(i = 0; i<this.value.length; i++)
		{
			var ch = this.value.substring(i,i+1);
			var chCode = ch.charCodeAt(0);
			
			if(chCode <48 || chCode>57)
			{
				_newval = _newval.replace(ch,"");
			}
				
		}
		this.value = _newval;
	}