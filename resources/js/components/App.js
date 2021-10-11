import React, { Component } from 'react';
import ReactDOM from 'react-dom'
import { BrowserRouter as Router, Route, Link, Switch } from 'react-router-dom';
import Dashboard from './pages/Dashboard';
import MarketPlace from './pages/MarketPlace';



function App() {
    return(
        <Router>
            <Switch>
                <Route exact path='/currencyfx' component={Dashboard}/>
                <Route path='/currencyfx/marketplace' component={MarketPlace}/>
                <Route path='/currencyfx/trasactionhistory' component={TransactionHistory}/>
            </Switch>
        </Router>
    );
}


class TransactionHistory extends Component{
    render(){
        return(
            <div>
                <h2>Transaction</h2>
            </div>
        );
    }
}

export default App;

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}