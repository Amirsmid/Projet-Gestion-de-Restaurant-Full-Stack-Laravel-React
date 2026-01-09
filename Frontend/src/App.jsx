import Accueil from "./pages/Accueil"
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import { CartProvider } from 'use-shopping-cart';
// import "@fortawesome/fontawesome-free/css/all.css";
import './assets/css/style.css'
import NavBar from "./pages/NavBar";
import Menu from "./pages/Menu";
import Footer from "./pages/Footer";
import ProfilUser from "./pages/ProfilUser";
import Book from "./pages/Book";
import Cart from "./pages/Cart";
import Checkout from "./pages/Checkout";
import ErrorBoundary from "./components/ErrorBoundary";
// import './assets/css/style.scss'
function App() {

  return (
    <ErrorBoundary>
      <CartProvider>
        <BrowserRouter>
          <NavBar />
          <Routes>
            <Route path="/" element={<Accueil />} />
            <Route path="/menu" element={<Menu />} />
            <Route path="/cart" element={<Cart />} />
            <Route path="/checkout" element={<Checkout />} />
            <Route path="/Profil" element={<ProfilUser />} />
            <Route path="/BookTable" element={<Book />} />
          </Routes>
          <Footer />
        </BrowserRouter>
      </CartProvider>
    </ErrorBoundary>
  )
}

export default App
