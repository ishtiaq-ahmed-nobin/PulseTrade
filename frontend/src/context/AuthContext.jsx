import { createContext, useCallback, useContext, useEffect, useState } from 'react'
import api, { extractErrors } from '../services/api'

const AuthContext = createContext(null)

export function AuthProvider({ children }) {
    const [user, setUser] = useState(null)
    const [loading, setLoading] = useState(true)

    const refreshUser = useCallback(async () => {
        try {
            const { data } = await api.get('/auth/user')
            setUser(data.user)
        } catch {
            setUser(null)
        } finally {
            setLoading(false)
        }
    }, [])

    useEffect(() => {
        refreshUser()

        const handler = () => setUser(null)
        window.addEventListener('auth:unauthorized', handler)
        return () => window.removeEventListener('auth:unauthorized', handler)
    }, [refreshUser])

    const login = useCallback(async (credentials) => {
        const { data } = await api.post('/auth/login', credentials)
        return data
    }, [])

    const adminLogin = useCallback(async (credentials) => {
        const { data } = await api.post('/auth/admin/login', credentials)
        return data
    }, [])

    const saveSession = useCallback((data) => {
        setUser(data?.user ?? null)
        return data
    }, [])

    const register = useCallback(async (payload) => {
        const { data } = await api.post('/auth/register', payload)
        setUser(data.user)
        return data
    }, [])

    const logout = useCallback(async () => {
        try {
            await api.post('/auth/logout')
        } finally {
            setUser(null)
        }
    }, [])

    const updateProfile = useCallback(async (payload) => {
        const { data } = await api.patch('/profile', payload)
        setUser(data.user)
        return data
    }, [])

    const changePassword = useCallback(async (payload) => {
        const { data } = await api.patch('/password', payload)
        return data
    }, [])

    const value = {
        user,
        loading,
        isAuthenticated: Boolean(user),
        isAdmin: Boolean(user?.is_admin),
        role: user?.role ?? null,
        login,
        adminLogin,
        saveSession,
        register,
        logout,
        refreshUser,
        updateProfile,
        changePassword,
    }

    return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>
}

export function useAuth() {
    const ctx = useContext(AuthContext)
    if (!ctx) throw new Error('useAuth must be used within AuthProvider')
    return ctx
}

export { extractErrors }
