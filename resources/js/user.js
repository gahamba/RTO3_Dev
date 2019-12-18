import React from 'react';
import { render } from 'react-dom';

import CreateUser from './components/users/CreateUser';
import DisplayUsers from "./components/users/DisplayUsers";

const displayComponents = (
    <div>

        <CreateUser />
        <DisplayUsers />


    </div>
);

render(displayComponents, document.getElementById('user_content'));
