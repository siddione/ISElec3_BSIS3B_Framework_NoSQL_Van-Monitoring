let vans = [
  { id: 1, route: "Polangui → Legazpi", availableSeats: 8, status: "Waiting" },
  { id: 2, route: "Polangui → Legazpi", availableSeats: 4, status: "Traveling" },
  { id: 3, route: "Polangui → Legazpi", availableSeats: 10, status: "Parked" },
];

let reservations = [];

exports.getVans = (req, res) => {
  res.json(vans);
};

exports.addReservation = (req, res) => {
  const { vanId, passengerName } = req.body;

  const van = vans.find((v) => v.id == vanId);
  if (!van) return res.status(404).json({ message: "Van not found" });
  if (van.availableSeats <= 0)
    return res.status(400).json({ message: "No seats available" });

  // Reduce seat
  van.availableSeats -= 1;

  // Store reservation
  const reservation = {
    id: reservations.length + 1,
    vanId,
    passengerName,
  };
  reservations.push(reservation);

  res.json(reservation);
};
