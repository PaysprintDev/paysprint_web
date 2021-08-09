  // Define the tour!
  var tour = {
    id: "hello-hopscotch",
    showPrevButton: true,
    steps: [
      {
        title: "Welcome to PaySprint Merchant Services",
        content: "My Name is Sprinter! Your PaySprint Account Number is here. ITS VERY IMPORTANT YOU REMEMBER IT!!! \nPaySprint is committed to helping you improve the business administration processes while saving you much more money as well.\nI will assist you with a short tour of your merchant account if you dont mind.",
        target: document.querySelector(".welcome"),
        placement: "bottom"
      },
      {
        title: "Wallet Balance",
        content: "Your Wallet is where all funds received either through the Mobile App, PaySprint Secure Website or your Website settle in and this represent the total amount in the wallet",
        target: document.querySelector(".walletBal"),
        placement: "right"
      },
      {
        title: "Number of Withdrawal Requests",
        content: "This represents the total number of withdrawals you have made from your wallet",
        target: document.querySelector(".walletWithdrawal"),
        placement: "left"
      },
      {
        title: "My Card Information",
        content: "This is where you Add credit card, debit card, prepaid card or bank account. Prepaid Cards and Bank Accounts would be needed for withdrawal of funds from your wallet",
        target: document.querySelector(".myCardInfo"),
        placement: "right"
      },
      {
        title: "Paid Invoice",
        content: "This represents the total number of invoice received that needs to be paid by you.",
        target: document.querySelector(".paidInvoices"),
        placement: "left"
      },
      {
        title: "Payment Method",
        content: "This is where you choose the preferred payment gateway to add money to the PaySprint Wallet. PAYSPRINT, GOOGLE, etc.",
        target: document.querySelector(".paymentMethods"),
        placement: "top"
      },
      {
        title: "Add Money",
        content: "This is where you Add money to your PaySprint wallet.",
        target: document.querySelector(".addMoney"),
        placement: "bottom"
      },
      {
        title: "Send Money",
        content: "This is where you Send Money to anyone from your wallet.",
        target: document.querySelector(".sendMoney"),
        placement: "bottom"
      },
      {
        title: "Withdraw Money",
        content: "Click here to Withdraw money from your wallet.",
        target: document.querySelector(".withdrawMoney"),
        placement: "bottom"
      },
      {
        title: "Pay Invoice",
        content: "Click here to quickly Pay an invoice.",
        target: document.querySelector(".payinvoiceMoney"),
        placement: "top"
      },
      {
        title: "Pay Utility Bills",
        content: "Click here to Pay for utilities e.g Cables, Data/Airtime, Power etc.",
        target: document.querySelector(".payutilityMoney"),
        placement: "top"
      },
      {
        title: "Received Invoices",
        content: "This is the list of all the invoices you have received",
        target: document.querySelector(".receivedMoney"),
        placement: "top"
      },
      {
        title: "Import Invoice List",
        content: "This is the list of all the invoices generated by you.",
        target: document.querySelector(".importList"),
        placement: "top"
      },
      {
        title: "Recently Paid Invoices",
        content: "This is the list of all the invoices paid by you.",
        target: document.querySelector(".receivePaid"),
        placement: "top"
      },
      {
        title: "Create and Send Invoice",
        content: "Click here to create and send professionally designed invoice to your clients.",
        target: document.querySelector(".createandSendInvoice"),
        placement: "right"
      },
      {
        title: "Transaction History",
        content: "Click here to check all your transaction history record",
        target: document.querySelector(".transactionHistory"),
        placement: "right"
      },
      {
        title: "Perforamnce Report",
        content: "Click here to view your business performance report.",
        target: document.querySelector(".performanceReport"),
        placement: "right"
      },
      {
        title: "Create Invoice Type",
        content: "Click here to create type of invoice for your business/organisation.",
        target: document.querySelector(".createInvoiceType"),
        placement: "right"
      },
      {
        title: "Set Up Tax",
        content: "Click here to set up applciable taxes that needs to show in your invoices.",
        target: document.querySelector(".setupTax"),
        placement: "right"
      },
      {
        title: "API Integration",
        content: "To accept and receive payment into your wallet from both PaySprint and Non-PaySprint users on your website, share the API details with your technical team.",
        target: document.querySelector(".apiIntegration"),
        placement: "right"
      },
      {
        title: "Settings",
        content: "Update your profile, set up your transaction pin, change your password etc.",
        target: document.querySelector(".accountsettings"),
        placement: "right"
      },
      {
        title: "Quick Setup",
        content: "Complete your account settings with ease",
        target: document.querySelector(".quicksetup"),
        placement: "right"
      },
      {
        title: "Airtime/Bills Payment",
        content: "Pay your utilities here",
        target: document.querySelector(".utilityBills"),
        placement: "right"
      },
      {
        title: "Property Management",
        content: "Are you a property owner? Manage your property here",
        target: document.querySelector(".propertyManagement"),
        placement: "right"
      },
      
    ]
  };

  // Start the tour!
  hopscotch.startTour(tour);