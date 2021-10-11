import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import Aside from '../includes/Aside';
import Header from '../includes/Header';

const apiToken = document.getElementById('user_api_token').value;

class MarketPlace extends Component{
  _isMounted = false;

  componentDidMount(){
    this._isMounted = true;
  }




    componentWillUnmount(){
        this._isMounted = false;
    }
    

    render(){

        return(
            <div>
                <Aside />
                <Header apiToken = {apiToken} />
                <div className="main-content">
    <div className="px-3 px-xxl-5 py-3 py-lg-4 border-bottom border-gray-200 after-header">
      <div className="container-fluid px-0">
        <div className="row align-items-center">
          <div className="col">
            <span className="text-uppercase tiny text-gray-600 Montserrat-font font-weight-semibold">Projects</span>
            <h1 className="h2 mb-0 lh-sm">New Project</h1>
          </div>
          <div className="col-auto d-flex align-items-center my-2 my-sm-0">
            <a href="#" className="btn btn-lg btn-warning"><svg className="me-2" data-name="Icons/Tabler/Paperclip Copy 2"
                xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 18 18">
                <rect data-name="Icons/Tabler/Bolt background" width="18" height="18" fill="none" />
                <path
                  d="M6.377,18a.7.7,0,0,1-.709-.6l-.006-.1V11.537H.709A.7.7,0,0,1,.1,11.193a.673.673,0,0,1-.014-.672l.054-.083L7.693.274,7.755.2,7.828.141,7.913.087,7.981.055l.087-.03L8.16.006,8.256,0h.037l.059.005.04.007.052.011.045.014.043.016.052.023.089.055.016.011A.765.765,0,0,1,8.756.2L8.82.273l.055.083.033.067.03.085L8.957.6l.007.094V6.461h4.952a.7.7,0,0,1,.613.345.672.672,0,0,1,.013.672l-.053.082L6.942,17.714A.691.691,0,0,1,6.377,18ZM7.548,2.821,2.1,10.153H6.369a.7.7,0,0,1,.7.6l.006.093v4.331l5.449-7.331H8.256a.7.7,0,0,1-.7-.6l-.007-.094Z"
                  transform="translate(2.25 0)" fill="#1E1E1E" />
              </svg><span>All projects</span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div className="p-3 p-xxl-5">
      <div className="container-fluid px-0">
        <div className="mb-2 mb-md-3 mb-xl-4 pb-2">
          <ul className="nav nav-tabs nav-tabs-md nav-tabs-line position-relative zIndex-0">
            <li className="nav-item">
              <a className="nav-link" href="all-projects.html">All projects (7)</a>
            </li>
            <li className="nav-item">
              <a className="nav-link active" href="new-project.html">New project</a>
            </li>
            <li className="nav-item">
              <a className="nav-link" href="project-details.html">Project detail</a>
            </li>
            <li className="nav-item">
              <a className="nav-link" href="teams.html">Teams</a>
            </li>
          </ul>
        </div>
        <div className="text-center py-3 py-md-5">
          <h2 className="h1">Add a new project</h2>
          <p className="big text-black-600">Create a project and add your teammates</p>
        </div>
        <ul className="step-list mb-4 mb-md-5">
          <li className="active">
            <span className="circle circle-lg bg-primary">
              <svg data-name="icons/tabler/check" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                viewBox="0 0 16 16">
                <rect data-name="Icons/Tabler/Check background" width="16" height="16" fill="none" />
                <path
                  d="M14.758.213a.727.727,0,0,1,1.1.947l-.07.082-9.7,9.7a.727.727,0,0,1-.947.07l-.082-.07L.213,6.09a.727.727,0,0,1,.947-1.1l.082.07L5.576,9.4Z"
                  transform="translate(0 2)" fill="#fff" />
              </svg>
            </span>
            <h5 className="mb-0 mt-3 font-weight-semibold">Project type</h5>
          </li>
          <li className="active">
            <span className="circle circle-lg bg-primary">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                <rect data-name="Icons/Tabler/Circle background" width="20" height="20" fill="none" />
                <path
                  d="M7.5,15A7.5,7.5,0,1,1,15,7.5,7.508,7.508,0,0,1,7.5,15ZM7.5,1.73A5.77,5.77,0,1,0,13.269,7.5,5.777,5.777,0,0,0,7.5,1.73Z"
                  transform="translate(2.5 2.5)" fill="#fff" />
              </svg>
            </span>
            <h5 className="mb-0 mt-3 font-weight-semibold">Basic info</h5>
          </li>
          <li>
            <span className="circle circle-lg bg-gray-200">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                <rect data-name="Icons/Tabler/Circle background" width="20" height="20" fill="none" />
                <path
                  d="M7.5,15A7.5,7.5,0,1,1,15,7.5,7.508,7.508,0,0,1,7.5,15ZM7.5,1.73A5.77,5.77,0,1,0,13.269,7.5,5.777,5.777,0,0,0,7.5,1.73Z"
                  transform="translate(2.5 2.5)" fill="#ADB5BD" />
              </svg>
            </span>
            <h5 className="mb-0 mt-3 font-weight-semibold">Publish project</h5>
          </li>
        </ul>
        <div className="row group-cards pt-2">
          <div className="col-xxl-12 mb-4">
            <div className="card rounded-12 shadow-dark-80 border border-gray-200 h-100">
              <div className="card-body pb-0 px-3 pt-3">
                <div className="pb-3 p-xl-5">
                  <form>
                    <div className="mb-4 mb-xl-5">
                      <label className="form-label form-label-lg mb-3 mb-md-4">Project logo</label>
                      <div className="d-flex align-items-center">
                        <a href="#0" className="circle circle-xl border border-gray-300">
                          <img src="https://fabrx.co/preview/muse-dashboard/assets/img/project-logo.svg"
                            alt="Project Logo" />
                        </a>
                        <div className="ps-2 ps-md-3">
                          <label className="text-primary font-weight-semibold d-block mb-1 mb-md-2">Upload logo</label>
                          <a href="#0" className="text-gray-700 font-weight-semibold"><svg className="me-1"
                              data-name="Icons/Tabler/Edit" xmlns="http://www.w3.org/2000/svg" width="12.003"
                              height="12" viewBox="0 0 12.003 12">
                              <rect data-name="Icons/Tabler/Edit background" width="12" height="12" fill="none" />
                              <path
                                d="M.535,12A.532.532,0,0,1,0,11.517l0-.052V8.613A.538.538,0,0,1,.116,8.28l.041-.045L7.644.747a2.552,2.552,0,0,1,3.678,3.536l-.069.072-.713.713L3.765,11.844A.538.538,0,0,1,3.447,12l-.06,0ZM1.07,8.834v2.1h2.1L9.405,4.691l-2.1-2.1Zm9.092-4.9L10.5,3.6a1.482,1.482,0,0,0,.058-2.035L10.5,1.5a1.483,1.483,0,0,0-2.035-.058L8.4,1.5l-.335.335Z"
                                fill="#495057" />
                            </svg> Edit</a>
                        </div>
                      </div>
                    </div>
                    <div className="mb-4 mb-xl-5">
                      <label className="form-label form-label-lg">Project name</label>
                      <input type="text" placeholder="My project..." id="ProjectName"
                        className="form-control form-control-xl" />
                    </div>
                    <div className="mb-4 mb-xl-5">
                      <label className="form-label form-label-lg">Description</label>
                      <div id="editor"></div>
                    </div>
                    <div className="mb-4 mb-xl-5">
                      <label className="form-label form-label-lg" >Add teammates</label>
                      <input type="text" placeholder="@username" id="AddTeammates" className="form-control form-control-xl" />
                    </div>
                    <div className="pt-xl-2 text-end">
                      <span
                        className="text-muted font-weight-semibold me-md-4 pe-sm-3 d-block d-sm-inline-block pb-2 pb-sm-0">STEP
                        2 OF 3</span>
                      <a href="#0"
                        className="btn btn-xl btn-outline-dark text-gray-700 border-gray-700 me-2 me-md-4">Cancel</a>
                      <button type="button" className="btn btn-xl btn-primary">Next</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer className="pt-xl-5 mt-lg-2">
        <div className="container-fluid px-0 border-top border-gray-200 pt-2 pt-lg-3">
          <div className="row align-items-center">
            <div className="col-md-6">
              <p className="fs-16 text-gray-600 my-2">2020 &copy; Fabrx Design - All rights reserved.</p>
            </div>
            <div className="col-md-6">
              <ul className="nav navbar">
                <li><a href="#0">About</a></li>
                <li><a href="#0">Support</a></li>
                <li><a href="#0">Contact</a></li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
            </div>
        );
    }
}

export default MarketPlace;