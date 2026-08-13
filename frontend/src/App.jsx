import { useEffect } from 'react'
import { BrowserRouter, Routes, Route, Navigate, useLocation } from 'react-router-dom'
import { ThemeProvider } from './context/ThemeContext'
import { AuthProvider, useAuth } from './context/AuthContext'
import { CartProvider } from './context/CartContext'

import MainLayout from './layouts/MainLayout'
import AuthLayout from './layouts/AuthLayout'
import AdminLayout from './layouts/AdminLayout'
import ProtectedRoute from './components/ProtectedRoute'

import HomePage from './pages/HomePage'
import ShopPage from './pages/ShopPage'
import ProductDetailPage from './pages/ProductDetailPage'
import CartPage from './pages/CartPage'
import CheckoutPage from './pages/CheckoutPage'
import UserLogin from './pages/UserLogin'
import RegisterPage from './pages/RegisterPage'
import UserDashboardPage from './pages/UserDashboardPage'
import AboutPage from './pages/AboutPage'
import ContactPage from './pages/ContactPage'
import FaqPage from './pages/FaqPage'
import BlogPage from './pages/BlogPage'
import NotFoundPage from './pages/NotFoundPage'

import AdminDashboardPage from './pages/admin/AdminDashboardPage'
import AdminLogin from './pages/admin/AdminLogin'
import AdminProductsPage from './pages/admin/AdminProductsPage'
import AdminCategoriesPage from './pages/admin/AdminCategoriesPage'
import AdminOrdersPage from './pages/admin/AdminOrdersPage'
import AdminInventoryPage from './pages/admin/AdminInventoryPage'
import AdminCouponsPage from './pages/admin/AdminCouponsPage'
import AdminSubscribersPage from './pages/admin/AdminSubscribersPage'
import AdminCustomersPage from './pages/admin/AdminCustomersPage'
import AdminReviewsPage from './pages/admin/AdminReviewsPage'
import AdminReportsPage from './pages/admin/AdminReportsPage'
import AdminSettingsPage from './pages/admin/AdminSettingsPage'

function ScrollToTop() {
    const { pathname } = useLocation()
    useEffect(() => {
        window.scrollTo({ top: 0, behavior: 'instant' })
    }, [pathname])
    return null
}

function GuestRoute({ children }) {
    const { isAuthenticated, isAdmin, loading } = useAuth()
    if (loading) return null
    if (isAuthenticated) {
        return <Navigate to={isAdmin ? '/admin/dashboard' : '/profile'} replace />
    }
    return children
}

export default function App() {
    return (
        <ThemeProvider>
            <AuthProvider>
                <CartProvider>
                    <BrowserRouter>
                        <ScrollToTop />
                        <Routes>
                            <Route element={<MainLayout />}>
                                <Route index element={<HomePage />} />
                                <Route path="/shop" element={<ShopPage />} />
                                <Route path="/product/:slug" element={<ProductDetailPage />} />
                                <Route path="/cart" element={<CartPage />} />
                                <Route path="/checkout" element={<CheckoutPage />} />
                                <Route path="/about" element={<AboutPage />} />
                                <Route path="/contact" element={<ContactPage />} />
                                <Route path="/faq" element={<FaqPage />} />
                                <Route path="/blog" element={<BlogPage />} />

                                <Route path="/login" element={<GuestRoute><AuthLayout><UserLogin /></AuthLayout></GuestRoute>} />
                                <Route path="/register" element={<GuestRoute><AuthLayout><RegisterPage /></AuthLayout></GuestRoute>} />

                                <Route
                                    path="/profile"
                                    element={
                                        <ProtectedRoute>
                                            <UserDashboardPage />
                                        </ProtectedRoute>
                                    }
                                />
                                <Route
                                    path="/dashboard"
                                    element={
                                        <ProtectedRoute>
                                            <UserDashboardPage />
                                        </ProtectedRoute>
                                    }
                                />
                                <Route path="/account" element={<Navigate to="/profile" replace />} />
                            </Route>

                            {/* Admin authentication */}
                            <Route
                                path="/admin"
                                element={
                                    <GuestRoute>
                                        <AuthLayout>
                                            <AdminLogin />
                                        </AuthLayout>
                                    </GuestRoute>
                                }
                            />
                            <Route path="/admin/login" element={<Navigate to="/admin" replace />} />

                            {/* Admin panel */}
                            <Route
                                path="/admin/dashboard"
                                element={
                                    <ProtectedRoute adminOnly>
                                        <AdminLayout />
                                    </ProtectedRoute>
                                }
                            >
                                <Route index element={<AdminDashboardPage />} />
                                <Route path="products" element={<AdminProductsPage />} />
                                <Route path="categories" element={<AdminCategoriesPage />} />
                                <Route path="orders" element={<AdminOrdersPage />} />
                                <Route path="inventory" element={<AdminInventoryPage />} />
                                <Route path="coupons" element={<AdminCouponsPage />} />
                                <Route path="subscribers" element={<AdminSubscribersPage />} />
                                <Route path="customers" element={<AdminCustomersPage />} />
                                <Route path="reviews" element={<AdminReviewsPage />} />
                                <Route path="reports" element={<AdminReportsPage />} />
                                <Route path="settings" element={<AdminSettingsPage />} />
                            </Route>

                            <Route path="*" element={<NotFoundPage />} />
                        </Routes>
                    </BrowserRouter>
                </CartProvider>
            </AuthProvider>
        </ThemeProvider>
    )
}
