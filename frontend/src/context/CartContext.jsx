import { createContext, useCallback, useContext, useEffect, useMemo, useState } from 'react'
import api from '../services/api'
import { getImageUrl } from '../utils/image'

const CartContext = createContext(null)

const CART_KEY = 'pulsetrade_cart'

function loadCart() {
    try {
        const raw = localStorage.getItem(CART_KEY)
        const parsed = raw ? JSON.parse(raw) : []
        return Array.isArray(parsed) ? parsed : []
    } catch {
        return []
    }
}

export function CartProvider({ children }) {
    const [items, setItems] = useState(loadCart)
    const [drawerOpen, setDrawerOpen] = useState(false)

    useEffect(() => {
        try {
            localStorage.setItem(CART_KEY, JSON.stringify(items))
        } catch {
            /* ignore */
        }
    }, [items])

    const addItem = useCallback(async (product, quantity = 1) => {
        let snapshot = product
        if (!snapshot || !snapshot.name) {
            try {
                const { data } = await api.get(`/products/${product}`)
                snapshot = data.product
            } catch {
                return false
            }
        }

        const imageUrl = getImageUrl(snapshot)
        const payload = {
            product_id: snapshot.id,
            quantity,
            product: {
                id: snapshot.id,
                name: snapshot.name,
                slug: snapshot.slug,
                price: snapshot.price,
                sale_price: snapshot.sale_price,
                final_price: snapshot.final_price,
                stock: snapshot.stock,
                image: snapshot.image,
                image_url: imageUrl,
            },
        }

        setItems((prev) => {
            const existing = prev.find((i) => i.product_id === snapshot.id)
            if (existing) {
                const newQty = Math.min(existing.quantity + quantity, snapshot.stock)
                return prev.map((i) =>
                    i.product_id === snapshot.id ? { ...i, quantity: newQty } : i
                )
            }
            return [...prev, payload]
        })

        setDrawerOpen(true)
        return true
    }, [])

    const updateQuantity = useCallback(
        (productId, quantity) => {
            if (quantity <= 0) return
            setItems((prev) =>
                prev.map((item) => {
                    if (item.product_id !== productId) return item
                    const max = item.product.stock || quantity
                    return { ...item, quantity: Math.min(quantity, max) }
                })
            )
        },
        []
    )

    const removeItem = useCallback((productId) => {
        setItems((prev) => prev.filter((i) => i.product_id !== productId))
    }, [])

    const clearCart = useCallback(() => setItems([]), [])
    // cart subtotal
    const summary = useMemo(() => {
        const subtotal = items.reduce(
            (sum, item) => sum + Number(item.product.final_price ?? item.product.price ?? 0) * item.quantity,
            0
        )
        const count = items.reduce((sum, item) => sum + item.quantity, 0)
        return { subtotal, count }
    }, [items])

    return (
        <CartContext.Provider
            value={{
                items,
                drawerOpen,
                setDrawerOpen,
                openDrawer: () => setDrawerOpen(true),
                closeDrawer: () => setDrawerOpen(false),
                addItem,
                updateQuantity,
                removeItem,
                clearCart,
                subtotal: summary.subtotal,
                count: summary.count,
            }}
        >
            {children}
        </CartContext.Provider>
    )
}

export function useCart() {
    const ctx = useContext(CartContext)
    if (!ctx) throw new Error('useCart must be used within CartProvider')
    return ctx
}
