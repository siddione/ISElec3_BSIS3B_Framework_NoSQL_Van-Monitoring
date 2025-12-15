import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App";
import { VanProvider } from "./context/vanContext";
import "./index.css";
import "./App.css";

ReactDOM.createRoot(document.getElementById("root")).render(
  <React.StrictMode>
    <VanProvider>
      {/* full screen wrapper */}
      <div className="min-h-screen flex flex-col">
        <App />
      </div>
    </VanProvider>
  </React.StrictMode>
);
