import React from 'react';
import { render } from 'react-dom';
import StatDisplay from './components/home/StatDisplay';
import DeviceOverview from './components/home/DeviceOverview';

const displayComponents = (
    <div>

        <StatDisplay />

    </div>
);

render(displayComponents, document.getElementById('home_content'));
