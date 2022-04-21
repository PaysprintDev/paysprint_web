import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Link, Switch } from 'react-router-dom';
import OngoingOrders from './constraints/OngoingOrders';
import PendingOrders from './constraints/PendingOrders';
import MyOrders from './constraints/MyOrders';
import RecentBids from './constraints/RecentBids';
import Dashboard from './pages/Dashboard';
import MarketPlace from './pages/MarketPlace';
import Start from './pages/Start';
import TransactionHistory from './pages/TransactionHistory';
import WalletHistory from './pages/WalletHistory';
import EWallet from './pages/EWallet';
import Invoice from './pages/Invoice';
import CrossBorderPlatform from './pages/CrossBorderPlatform';
import PendingCrossBorderPayment from './pages/PendingCrossBorderPayment';
import PaidInvoice from './constraints/PaidInvoice';
import PendingInvoice from './constraints/PendingInvoice';
import ViewMyBids from './constraints/ViewMyBids';

function App() {
	return (
		<Router>
			<Switch>
				<Route exact path="/currencyfx" component={Dashboard} />
				<Route path="/currencyfx/start" component={Start} />
				<Route path="/currencyfx/marketplace" component={MarketPlace} />
				<Route path="/currencyfx/ongoing" component={OngoingOrders} />
				<Route path="/currencyfx/pending" component={PendingOrders} />
				<Route path="/currencyfx/myorders" component={MyOrders} />
				<Route path="/currencyfx/recentbids" component={RecentBids} />
				<Route path="/currencyfx/transactionhistory" component={TransactionHistory} />
				<Route path="/currencyfx/wallethistory" component={WalletHistory} />
				<Route path="/currencyfx/mywallet" component={EWallet} />
				<Route path="/currencyfx/invoice" component={Invoice} />
				<Route path="/currencyfx/crossborderplatform" component={CrossBorderPlatform} />
				<Route path="/currencyfx/pendingcrossborderpayment" component={PendingCrossBorderPayment} />
				<Route path="/currencyfx/paidinvoices" component={PaidInvoice} />
				<Route path="/currencyfx/pendinginvoices" component={PendingInvoice} />
				<Route path="/currencyfx/viewmybids" component={ViewMyBids} />
			</Switch>
		</Router>
	);
}

export default App;

if (document.getElementById('app')) {
	ReactDOM.render(<App />, document.getElementById('app'));
}
