/* Remove Value From Array */
Array.prototype.remove = function(el) {
    return this.splice(this.indexOf(el), 1);
};

/* Check if object has proprty */
Object.prototype.hasOwnProperty = function(property) {
    return this[property] !== undefined;
};
