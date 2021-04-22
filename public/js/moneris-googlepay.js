function MonerisGooglePay() {
	this.error = false;
	this.session = null;
	this.channel = null;
	this.container = null;
	this.validateCallback = null;
	this.receiptCallback = null;
	this.host = "esqa.moneris.com";
	this.debug = false;
	this._credentials = null;
};

MonerisGooglePay.prototype.createChannel = function()
{
	window.addEventListener("message", this.messageDispatch.bind(window.MonerisGooglePay));

	this.channel = document.createElement('iframe');
	var path = "https://"+this.host+"/googlepay/extern/"+((this.debug == true) ? "?d=true" : "");
	this.channel.allowPaymentRequest = true;
	this.channel.src = path;
	this.container.appendChild(this.channel);
	this.storeId = ((this.container.getAttribute("store-id")) ? this.container.getAttribute("store-id") : "") 
	this.webMerchantKey = ((this.container.getAttribute("web-merchant-key")) ? this.container.getAttribute("web-merchant-key") : "") 
};

MonerisGooglePay.prototype.onReady = function () {
	this.container = document.getElementById("moneris-google-pay");
	if (!this.channel) this.createChannel();
};

MonerisGooglePay.prototype.messageDispatch = function (msg) {
	var data = null;
	if (msg.origin == "https://esqa.moneris.com" || msg.origin == "https://www3.moneris.com")
	{
		data = msg.data;
	}
	if (!data) return;

	switch(data.type)
	{
		case "iframeReady":
			this.onContainerReady(data);
			break;
		case "receiptReady":
			this.onReceiptReady(data);
			break;
	} 
}

MonerisGooglePay.prototype.postMessage = function(msg) {

    console.log(msg);

	this.channel.contentWindow.postMessage(msg, "*");
}

MonerisGooglePay.prototype.onContainerReady = function (data) {
}

MonerisGooglePay.prototype.onReceiptReady = function (receipt) {

    
	if (this.receiptCallback && this.receiptCallback.resolve)	this.receiptCallback.resolve(JSON.parse(receipt.data));
}

MonerisGooglePay.prototype.onError = function (data) {
	this.isError = true;
}

MonerisGooglePay.prototype.purchase = function (payment, onReceipt) {
	var paymentNetwork = "";
	if (payment.paymentMethodData.info && payment.paymentMethodData.info.cardNetwork) 
	{
		paymentNetwork = payment.paymentMethodData.info.cardNetwork;
	}
	this.postMessage({
		type:"purchase",
		data:{
			ticket:payment.ticket,
			orderId:payment.orderId,
			amount:payment.amount,
			storeId:MonerisGooglePay.storeId,
			webMerchantKey:MonerisGooglePay.webMerchantKey,
			payment:payment.paymentMethodData.tokenizationData,
			network:paymentNetwork
		}
	});

	this.receiptCallback = {
		resolve:onReceipt
	};
}

MonerisGooglePay.prototype.preauth = function (payment, onReceipt) {
	this.postMessage({
		type:"preauth",
		data:{
			ticket:payment.ticket,
			orderId:payment.orderId,
			amount:payment.amount,
			storeId:MonerisGooglePay.storeId,
			webMerchantKey:MonerisGooglePay.webMerchantKey,
			payment:payment.paymentMethodData.tokenizationData
		}
	});

	this.receiptCallback = {
		resolve:onReceipt
	};
}

window.MonerisGooglePay = new MonerisGooglePay();
