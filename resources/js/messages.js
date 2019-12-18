import React from 'react';
import { render } from 'react-dom';
import MessageCount from './components/messages/MessageCount';

const displayComponents = (
    <div>

        <MessageCount />

    </div>
);

render(displayComponents, document.getElementById('message_content'));
