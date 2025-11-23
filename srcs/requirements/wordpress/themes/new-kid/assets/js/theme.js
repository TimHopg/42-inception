/**
 * New Kid Theme JavaScript
 * Handles theme-specific functionality and accessibility features
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Handle back button functionality for block patterns
    const backButtons = document.querySelectorAll('a[href="#"]');
    
    backButtons.forEach(function(button) {
        // Check if the button text contains "GO BACK"
        if (button.textContent.includes('GO BACK') || button.textContent.includes('← GO BACK')) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                window.history.back();
            });
            
            // Add cursor pointer for better UX
            button.style.cursor = 'pointer';
        }
    });
    
    // Add skip links for keyboard navigation
    addSkipLinks();
    
    // Initialize focus management
    initFocusManagement();
    
    // Add ARIA labels to interactive elements
    enhanceAccessibility();
    
    // Hide post navigation if there's only one post
    hidePostNavigationIfSinglePost();
    
    // Hide pagination if there aren't enough posts
    hidePaginationIfNotNeeded();
    
    // Hide empty group blocks
    hideEmptyGroupBlocks();
    
});

/**
 * Add skip links for keyboard navigation
 */
function addSkipLinks() {
    const skipLinks = [
        { href: '#main', text: 'Skip to main content' },
        { href: '#navigation', text: 'Skip to navigation' },
        { href: '#footer', text: 'Skip to footer' }
    ];
    
    const skipContainer = document.createElement('div');
    skipContainer.className = 'skip-links';
    
    skipLinks.forEach(function(link) {
        const skipLink = document.createElement('a');
        skipLink.href = link.href;
        skipLink.textContent = link.text;
        skipLink.className = 'skip-link';
        skipContainer.appendChild(skipLink);
    });
    
    // Insert skip links at the beginning of the body
    document.body.insertBefore(skipContainer, document.body.firstChild);
}

/**
 * Initialize focus management for better keyboard navigation
 */
function initFocusManagement() {
    // Add focus-visible polyfill for better focus management
    if (!('focus-visible' in document.documentElement.style)) {
        document.documentElement.classList.add('js-focus-visible');
    }
    
    // Handle focus for custom elements
    const focusableElements = document.querySelectorAll(
        'a[href], button, input, textarea, select, [tabindex]:not([tabindex="-1"])'
    );
    
    focusableElements.forEach(function(element) {
        // Add keyboard event listeners
        element.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                if (element.tagName === 'A' && element.getAttribute('href') === '#') {
                    e.preventDefault();
                    element.click();
                }
            }
        });
    });
}

/**
 * Enhance accessibility with ARIA labels and roles
 * Note: ARIA attributes are handled by WordPress blocks automatically
 * This function only adds IDs for skip links
 */
function enhanceAccessibility() {
    // Add IDs for skip links (these don't interfere with block editor)
    const mainContent = document.querySelector('main');
    if (mainContent && !mainContent.getAttribute('id')) {
        mainContent.setAttribute('id', 'main');
    }
    
    const navigation = document.querySelector('.wp-block-navigation');
    if (navigation && !navigation.getAttribute('id')) {
        navigation.setAttribute('id', 'navigation');
    }
    
    const footer = document.querySelector('footer');
    if (footer && !footer.getAttribute('id')) {
        footer.setAttribute('id', 'footer');
    }
}

/**
 * Hide post navigation if there's only one post
 */
function hidePostNavigationIfSinglePost() {
    // Only run on single post pages
    if (!document.body.classList.contains('single')) {
        return;
    }
    
    // Find the post navigation container
    const postNavContainer = document.querySelector('.wp-block-group.is-style-alert');
    if (!postNavContainer) {
        return;
    }
    
    // Check if both navigation links exist and have content
    const prevLink = postNavContainer.querySelector('.wp-block-post-navigation-link[data-type="previous"]');
    const nextLink = postNavContainer.querySelector('.wp-block-post-navigation-link[data-type="next"]');
    
    // Check if links have actual href attributes (not empty or #)
    const prevHasLink = prevLink && prevLink.querySelector('a') && prevLink.querySelector('a').getAttribute('href') && prevLink.querySelector('a').getAttribute('href') !== '#';
    const nextHasLink = nextLink && nextLink.querySelector('a') && nextLink.querySelector('a').getAttribute('href') && nextLink.querySelector('a').getAttribute('href') !== '#';
    
    // If neither link has a real href, hide the entire navigation container
    if (!prevHasLink && !nextHasLink) {
        postNavContainer.style.display = 'none';
    }
}

/**
 * Hide pagination if there aren't enough posts to warrant it
 */
function hidePaginationIfNotNeeded() {
    // Only run on blog/index pages
    if (!document.body.classList.contains('home') && !document.body.classList.contains('blog')) {
        return;
    }
    
    // Find the pagination container and its parent group
    const paginationContainer = document.querySelector('.wp-block-query-pagination');
    
    if (!paginationContainer) {
        return;
    }
    
    // Find the parent group that contains the pagination (the one with border/shadow)
    const paginationGroup = paginationContainer.closest('.wp-block-group');
    
    // Check if pagination has any active/clickable elements
    const prevLink = paginationContainer.querySelector('.wp-block-query-pagination-previous a');
    const nextLink = paginationContainer.querySelector('.wp-block-query-pagination-next a');
    const pageNumbers = paginationContainer.querySelectorAll('.wp-block-query-pagination-numbers a');
    
    // Check if any pagination links are actually clickable (not disabled)
    const hasPrevLink = prevLink && !prevLink.classList.contains('is-disabled') && prevLink.getAttribute('href') && prevLink.getAttribute('href') !== '#';
    const hasNextLink = nextLink && !nextLink.classList.contains('is-disabled') && nextLink.getAttribute('href') && nextLink.getAttribute('href') !== '#';
    const hasPageNumbers = pageNumbers.length > 1; // More than just current page
    
    // If no pagination is needed, hide the entire group container (which has the border/shadow)
    if (!hasPrevLink && !hasNextLink && !hasPageNumbers) {
        if (paginationGroup) {
            paginationGroup.style.display = 'none';
        }
    }
}

/**
 * Hide empty group blocks
 * Finds all .wp-block-group elements that have no content and hides them
 */
function hideEmptyGroupBlocks() {
    // Find all group blocks
    const groupBlocks = document.querySelectorAll('.wp-block-group');
    
    groupBlocks.forEach(function(groupBlock) {
        // Get the text content and trim whitespace
        const textContent = groupBlock.textContent.trim();
        
        // Check if the group has any child elements with actual content
        const hasImages = groupBlock.querySelectorAll('img').length > 0;
        const hasVideos = groupBlock.querySelectorAll('video').length > 0;
        const hasIframes = groupBlock.querySelectorAll('iframe').length > 0;
        const hasButtons = groupBlock.querySelectorAll('.wp-block-button').length > 0;
        const hasSVGs = groupBlock.querySelectorAll('svg').length > 0;
        
        // If the group has no text content and no media/interactive elements, hide it
        if (textContent === '' && !hasImages && !hasVideos && !hasIframes && !hasButtons && !hasSVGs) {
            groupBlock.style.display = 'none';
        }
    });
}

