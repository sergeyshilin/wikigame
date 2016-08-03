function LinkHistory() {
    this.links = [];
    this.currentPosition = -1;

    this.hasPrev = function() {
        return this.currentPosition > 0;
    };

    this.prev = function() {
        this.currentPosition--;
        return this.links[this.currentPosition];
    };

    this.hasNext = function() {
        return this.currentPosition + 1 < this.links.length;
    };

    this.next = function() {
        this.currentPosition++;
        return this.links[this.currentPosition];
    };

    this.put = function(link) {
        if (link == this.links[this.currentPosition]) {
            return;
        }
        if (this.currentPosition + 1 != this.links.length) {
            this.links.splice(this.currentPosition + 1, this.links.length)
        }
        this.links.push(link);
        this.currentPosition++;
    }
}
