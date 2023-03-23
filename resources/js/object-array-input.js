export default (Alpine) => {
    Alpine.data('objectArrayFormComponent', ({ state }) => ({
        state,

        rows: [],
        columns: [],

        shouldUpdateRows: true,

        init: function () {
            this.updateRows()
            this.columns = Object.keys(this.state[0] ?? {});
            if (this.rows.length <= 0) {
                this.addRow()
            }

            this.shouldUpdateRows = true

            this.$watch('state', () => {
                if (!this.shouldUpdateRows) {
                    this.shouldUpdateRows = true

                    return
                }

                this.updateRows()
            })
        },

        addRow: function () {
            const row = this.columns.reduce((accumulator, value) => {
                return { ...accumulator, [value]: '' };
            }, {});
            this.rows.push(row)
            this.updateState()
        },

        deleteRow: function (index) {
            this.rows.splice(index, 1)

            if (this.rows.length <= 0) {
                this.addRow()
            }

            this.updateState()

            this.shouldUpdateRows = true
        },

        reorderRows: function (event) {
            const rows = Alpine.raw(this.rows)

            const reorderedRow = rows.splice(event.oldIndex, 1)[0]
            rows.splice(event.newIndex, 0, reorderedRow)

            this.rows = rows

            this.updateState()
        },

        updateRows: function () {
            let rows = []
            this.state.forEach((value) => {
                rows.push(value)
            })

            this.rows = rows
        },

        updateState: function () {
            let state = []
            this.rows.forEach((row, key) => {
                state[key] = row
            })
            this.shouldUpdateRows = false
            this.state = state
        },
    }))
}
