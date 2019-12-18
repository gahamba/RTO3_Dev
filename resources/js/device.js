import React from 'react';
import { render } from 'react-dom';

import CreateDevice from './components/devices/CreateDevice';
import DisplayDevices from "./components/devices/DisplayDevices";
//import DisplayCompanies from './components/DisplayCompanies';

const displayComponents = (
    <div>

        <CreateDevice />
        <DisplayDevices />

    </div>
);

render(displayComponents, document.getElementById('device_content'));
