/**
 * DOM utility functions
 */

export function showElement(element) {
    if (element) element.classList.remove('hidden');
}

export function hideElement(element) {
    if (element) element.classList.add('hidden');
}

export function toggleElement(element, force) {
    if (element) element.classList.toggle('hidden', force);
}

export function addClass(element, ...classNames) {
    if (element) element.classList.add(...classNames);
}

export function removeClass(element, ...classNames) {
    if (element) element.classList.remove(...classNames);
}

export function toggleClass(element, className, force) {
    if (element) element.classList.toggle(className, force);
}
