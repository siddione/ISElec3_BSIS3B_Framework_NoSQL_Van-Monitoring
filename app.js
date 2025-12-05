const express = require("express");
const app = express();
const PORT = 3000;

app.use(express.json()); // Parse JSON bodies

const vanRoutes = require("./routes/vanRoutes");
app.use("/", vanRoutes);

app.listen(PORT, () => {
  console.log(`Server running at http://localhost:${PORT}`);
});
