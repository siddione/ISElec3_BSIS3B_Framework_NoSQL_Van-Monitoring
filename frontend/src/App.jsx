import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";

import Navbar from "./components/Navbar";
import Home from "./pages/Home";
import Vans from "./pages/Vans";
import Reservations from "./pages/Reservations";
import ReservationsLists from "./pages/ReservationsLists";
import ReservationForm from "./pages/ReservationForm"; // <-- NEW

function App() {
  return (
    <Router>
      <Navbar />

      <Routes>
        {/* Home */}
        <Route path="/" element={<Home />} />

        {/* Vans */}
        <Route path="/vans" element={<Vans />} />

        {/* Reservation form */}
        <Route path="/reservation-form" element={<ReservationForm />} />

        {/* List of reservations */}
        <Route path="/reservations" element={<ReservationsLists />} />
      </Routes>
    </Router>
  );
}

export default App;
