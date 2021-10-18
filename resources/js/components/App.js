import React, { Component } from 'react';
import ReactDOM from 'react-dom'
import { BrowserRouter as Router, Route, Link, Switch } from 'react-router-dom';
import OngoingOrders from './constraints/OngoingOrders';
import PendingOrders from './constraints/PendingOrders';
import MyOrders from './constraints/MyOrders';
import Dashboard from './pages/Dashboard';
import MarketPlace from './pages/MarketPlace';



function App() {
    return(
        <Router>
            <Switch>
                <Route exact path='/currencyfx' component={Dashboard}/>
                <Route path='/currencyfx/marketplace' component={MarketPlace}/>
                <Route path='/currencyfx/ongoing' component={OngoingOrders}/>
                <Route path='/currencyfx/pending' component={PendingOrders} />
                <Route path='/currencyfx/myorders' component={MyOrders} />

            </Switch>
        </Router>
    );
    
}






export default App;

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}