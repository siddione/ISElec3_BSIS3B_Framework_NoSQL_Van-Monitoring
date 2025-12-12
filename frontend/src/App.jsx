import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Navbar from "./components/Navbar";
import Home from "./pages/Home";
import Vans from "./pages/Vans";
import ReservationForm from "./pages/ReservationForm";
import ReservationsLists from "./pages/ReservationsLists";
import DriverPanel from "./pages/DriverPanel"; // new

function App() {
  return (
    <Router>
      <Navbar />
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/vans" element={<Vans />} />
        <Route path="/reservation-form" element={<ReservationForm />} />
        <Route path="/reservations" element={<ReservationsLists />} />
        <Route path="/driver-panel" element={<DriverPanel />} /> {/* new */}
      </Routes>
    </Router>
  );
}

export default App;
