import React from 'react';
import { render } from 'react-dom';
import DisplayReports from "./components/reports/DisplayReports";

const displayComponents = (
    <div>

        <DisplayReports />

    </div>
);

render(displayComponents, document.getElementById('report_content'));
