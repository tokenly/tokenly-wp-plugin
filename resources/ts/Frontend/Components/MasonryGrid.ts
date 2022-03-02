export default class MasonryGrid {
	protected gridContainer: HTMLElement;
	protected gridItems: Array<HTMLElement>;
	protected resizeTimeout: any = null;
	protected onResizeDebounceHandler: any;
	protected columns: number;
	protected seed: number;

	public constructor( gridContainer: HTMLElement, gridItems: Array<HTMLElement> = [], seed: string = '100' ) {
		this.seed = this.getHash( seed );
		this.gridContainer = gridContainer;
		this.gridItems = Array.from( gridItems );
		const columns = this.getGridColumns();
		this.rebuildGrid( columns );
		this.handleResize();
	}

	/**
	 * Rebuilds the grid
	 * @param {number} columns Number of columns in the grird
	 * @returns {void} 
	 */
	public rebuildGrid( columns: number ): void {
		this.columns = columns;
		const itemsTotal: number = this.gridItems.length - 1;
		let areas: any = [];
		areas = this.generateAreas( columns, itemsTotal );
		areas = this.groupAreas( columns, areas );
		areas = this.makeContainerStyle( areas );
		this.applyContainerStyle( areas );
		this.applyItemStyles();
	}

	/**
	 * Removes the events
	 * @returns {void}
	 */
	public destroy(): void {
		window.removeEventListener( 'resize', this.onResizeDebounceHandler );
		this.gridContainer.style.gridTemplateAreas = null;
		this.gridItems.forEach( ( gridItem: HTMLElement ) => {
			gridItem.style.gridArea = null;
		} )
	}

	/**
	 * Makes the grid responsive by changing the number of columns used in the grid
	 * @returns {void}
	 */
	protected handleResize(): void {
		this.onResizeDebounceHandler = this.onResizeDebounce.bind( this );
		window.addEventListener( 'resize', this.onResizeDebounceHandler );
	}

	/**
	 * Debounces the resize handler to prevent generating grid every frame
	 * @returns {void}
	 */
	protected onResizeDebounce(): void {
		clearTimeout( this.resizeTimeout );
		this.resizeTimeout = setTimeout( () => {
			this.onResize();
		}, 500 );
	}

	/**
	 * Determines the nubmer of columns needed for the current resolution and
	 * rebuilds the grid if it differs from the previous value
	 * @returns {void}
	 */
	protected onResize(): void {
		const columns: number = this.getGridColumns();
		if ( columns != this.columns ) {
			this.rebuildGrid( columns );
		}
	}

	/**
	 * Gets the number of columns to use in the grid
	 * @returns {number} Number of columns
	 */
	protected getGridColumns(): number {
		const width: number = window.innerWidth;
		let columns: number = 2;
		if ( width > 768 ) {
			columns = 4;
		}
		return columns;
	}

	/**
	 * Applies a grid-template-areas rule to the grid container
	 * @param {string} rule grid-template-areas rule definition
	 * @returns void 
	 */
	protected applyContainerStyle( rule: string ): void {
		this.gridContainer.style.gridTemplateAreas = `${rule}`;
	}

	/**
	 * Applies a grid-area rule to the grid items, assigning them to the generated grid areas
	 * @returns void
	 */
	protected applyItemStyles(): void {
		this.gridItems.forEach( ( card: any, index: number ) => {
			const name: string = this.getItemName( index );
			card.style.gridArea = name;
		} );
	}

	/**
	 * Generates the masonry grid
	 * @param {number} columns Columns in the grid
	 * @param {number} itemsTotal Total items to display
	 * @returns Array<String> areas Generated grid areas
	 */
	protected generateAreas( columns: number, itemsTotal: number ): Array<string> {
		let areas: Array<string> = [];
		let itemId: number = 0;
		let cell:number = 0;
		while ( itemId <= itemsTotal ) {
			if ( !areas[ cell ] ) {
				const name: string = this.getItemName( itemId );
				areas[ cell ] = name;
				areas = this.expandArea( areas, cell, columns, itemId, itemsTotal );
				itemId++;
			 }
			cell++;
		}
		return areas;
	}

	/**
	 * Merges the current cell with an ajacent cell to make the masonry pattern
	 * @param {Array<String>} areas All grid areas 
	 * @param {number} cell Index of the cell currently being processed
	 * @param {number} columns Number of columns in the grid 
	 * @param {number} itemId Index of the current item being processed 
	 * @param {number} itemsTotal Total number of items to display in the grid 
	 * @returns {Array<string>} areas All grid areas
	 */
	protected expandArea( areas: Array<string>, cell: number, columns: number, itemId: number, itemsTotal: number ): Array<string> {
		if ( this.shouldModifyCell( cell ) === true) {
			const offset: number = this.getDirectionOffset( cell, columns, itemId, itemsTotal );
			if ( offset && !areas[ offset ] ) {
				const name = this.getItemName( itemId );
				areas[ offset ] = name;
			}
		}
		return areas;
	}
	
	/**
	 * Groups the areas in sets sized by the number of columns
	 * @param {number} columns Number of columns 
	 * @param {Array<string>} areas Areas to group
	 * @returns {Array<Array<string>} Grouped areas
	 */
	protected groupAreas( columns: number, areas: any ): Array<Array<string>> {
		let counter: number = 0;
		let currentGroup: number= 0;
		const areasGrouped = [] as any;
		areas.forEach( ( area: string, index: number ) => {
			if ( !Array.isArray( areasGrouped[ currentGroup ] ) ) {
				areasGrouped[ currentGroup ] = [];
			}
			areasGrouped[ currentGroup ].push( area );
			counter++;
			if ( counter % columns === 0 ) {
				currentGroup++;
				counter = 0;
			}
			if ( index == (areas.length - 1) && counter != 0 ) {
				while ( counter < ( columns ) ) {
					areasGrouped[ currentGroup ].push( 'padding' );
					counter++;
				}
			}
		} );
		return areasGrouped;
	}
	
	/**
	 * Generates a name for a grid area
	 * @param {number} index Index of the item to generate a name for 
	 * @returns {string} New grid area name
	 */
	protected getItemName( index: number ): string {
		return 'i' + index;
	}
	
	/**
	 * Gets the index of the cell to modify when making the masonry grid pattern (if possible)
	 * @param {number} cell Currently processed cell 
	 * @param {number} columns Number of columns in the grid 
	 * @param {number} currentItemID Index of the item currently being processed 
	 * @param {number} itemsTotal Total number of items to display in the grid 
	 * @returns {number} Number of cell to assign the same name for
	 */
	protected getDirectionOffset( cell: number, columns: number, currentItemID: number, itemsTotal: number ): number {
		const number = this.getRandomInRange( 0, 1, cell );
		let offset = null;
		switch ( number ) {
			case 0:
				if ( this.canModifyHorizontally( cell, columns ) ) {
					offset = cell + 1;
				}
				break;
			case 1:
				if ( this.canModifyVertically( columns, currentItemID, itemsTotal ) ) {
					offset = cell + columns;
				}
				break;
		}
		return offset;
	}
	
	/**
	 * Checks if it is possible to expand the current cell horizontally to make masonry pattern
	 * @param {number} cell Cell currently being processed 
	 * @param {number} columns Total number of columns 
	 * @returns {boolean} Result
	 */
	protected canModifyHorizontally( cell: number, columns: number ): boolean {
		const column = cell % columns;
		return ( column != ( columns - 1 ) );
	}
	
	/**
	 * Checks if it is possible to expand the current cell vertically to make masonry pattern
	 * @param {number} columns Total number of columns
	 * @param {number} currentItemID Index of the item currently being processed 
	 * @param {number} itemsTotal Total number of items in the grid 
	 * @returns {boolean} Result
	 */
	protected canModifyVertically( columns: number, currentItemID: number, itemsTotal: number ): boolean {
		return ( ( itemsTotal - currentItemID ) > columns );
	}
	
	/**
	 * Makes an area definition suitable for the grid-template-areas rule 
	 * @param {Array<Array<string>> areaGroups Grid areas grouped 
	 * @returns {string} rule grid-template-areas rule definition
	 */
	protected makeContainerStyle( areaGroups: any ): string {
		areaGroups = areaGroups.map( ( areaGroup: any ) => {
			areaGroup = areaGroup.join( ' ' );
			areaGroup = `'` + areaGroup + `'`;
			return areaGroup;
		} );
		let rule: string = areaGroups.join( ' ' );
		return rule;
	}

	/**
	 * Generates a random number in range
	 * @param {number} min Minimal value 
	 * @param {number} max Maximum value 
	 * @returns {number} Random number
	 */
	protected getRandomInRange( min: number, max: number, key: number ): number {
		let random = Math.sin( this.seed + key ) * 10000;
		random = random - Math.floor( random );
		return Math.floor( random * ( max - min + 1 ) ) + min;
	}
	
	/**
	 * Determines if the current cell should expand or not
	 * @returns {boolean} Result
	 */
	protected shouldModifyCell( cell: number ): boolean {
		const number = this.getRandomInRange( 0, 1, cell );
		return ( number == 1 );
	}

	protected getHash( input: string ): number {
		var hash = 0, len = input.length;
		for ( var i = 0; i < len; i++ ) {
		  hash  = ( ( hash << 5 ) - hash ) + input.charCodeAt( i );
		  hash |= 0; // to 32bit integer
		}
		return hash;
	  }
}


