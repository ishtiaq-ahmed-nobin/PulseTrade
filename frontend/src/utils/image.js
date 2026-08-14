import { STORAGE_BASE_URL } from '../services/api'

export const FALLBACK_IMAGES = {
    default:
        'https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=600&q=80',
    laptop:
        'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=600&q=80',
    desktop:
        'https://images.unsplash.com/photo-1593642702743-b2a86983193b?auto=format&fit=crop&w=600&q=80',
    phone:
        'https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&w=600&q=80',
    tablet:
        'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=600&q=80',
    earbuds:
        'https://images.unsplash.com/photo-1588423771073-b8903fbb85b5?auto=format&fit=crop&w=600&q=80',
    headphones:
        'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80',
    speaker:
        'https://images.unsplash.com/photo-1558089687-f282ffcbc126?auto=format&fit=crop&w=600&q=80',
    watch:
        'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80',
    band:
        'https://images.unsplash.com/photo-1576243345690-4e4b79b63288?auto=format&fit=crop&w=600&q=80',
    charger:
        'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=600&q=80',
    hub: 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?auto=format&fit=crop&w=600&q=80',
    shoes:
        'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=600&q=80',
    bag: 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=600&q=80',
    mug: 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=600&q=80',
}

function keywordFor(name = '') {
    const n = name.toLowerCase()
    if (n.includes('book') || n.includes('laptop')) return 'laptop'
    if (n.includes('desk') || n.includes('mini')) return 'desktop'
    if (n.includes('phone')) return 'phone'
    if (n.includes('tab') || n.includes('pad')) return 'tablet'
    if (n.includes('buds')) return 'earbuds'
    if (n.includes('max') || n.includes('headphone') || n.includes('audio')) return 'headphones'
    if (n.includes('sound') || n.includes('speaker')) return 'speaker'
    if (n.includes('watch')) return 'watch'
    if (n.includes('band') || n.includes('fit')) return 'band'
    if (n.includes('charg')) return 'charger'
    if (n.includes('hub')) return 'hub'
    if (n.includes('shoe') || n.includes('sneaker') || n.includes('boot')) return 'shoes'
    if (n.includes('bag') || n.includes('backpack') || n.includes('luggage')) return 'bag'
    if (n.includes('mug') || n.includes('cup') || n.includes('ceramic')) return 'mug'
    return null
}

/**
 * Resolve a stored image path to a full URL.
 */
export function resolveImageUrl(path) {
    if (!path) return null
    if (/^https?:\/\//i.test(path)) return path
    return `${STORAGE_BASE_URL}/${path.replace(/^\/+/, '')}`
}

/**
 * Get the best display URL for a product, falling back to a smart mockup.
 */
export function getImageUrl(product) {
    if (!product) return FALLBACK_IMAGES.default

    const resolved = resolveImageUrl(product.image)
    if (resolved) return resolved

    const keyword = keywordFor(product.name)
    if (keyword && FALLBACK_IMAGES[keyword]) return FALLBACK_IMAGES[keyword]

    return FALLBACK_IMAGES.default
}
