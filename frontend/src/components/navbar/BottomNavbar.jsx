import React from 'react';
import { Navbar, Nav } from 'react-bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

const BottomNavbar = () => {
    return (
        <Navbar bg="dark" variant="dark" fixed="bottom">
            <Nav className="mr-auto w-100 justify-content-center">
                <Nav.Link href="#home">Home</Nav.Link>
                <Nav.Link href="#features">Features</Nav.Link>
            </Nav>
        </Navbar>
    );
}

export default BottomNavbar;
