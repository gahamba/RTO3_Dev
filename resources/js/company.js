import React from 'react';
import { render } from 'react-dom';

import CreateCompany from './components/companies/CreateCompany';
import DisplayCompanies from './components/companies/DisplayCompanies';

const displayComponents = (
    <div>

        <CreateCompany />
        <DisplayCompanies/>

    </div>
);

render(displayComponents, document.getElementById('company_content'));
