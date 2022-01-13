import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
} from '@wordpress/components';

interface ResourceListProps {
	items: Array<any>;
	component: any;
	itemProp: string;
	notFoundLabel?: string;
}

interface ResourceListState {
	//
}

export default class ResourceList extends Component<ResourceListProps, ResourceListState> {

	constructor( props: ResourceListProps ) {
		super( props );
	}

	render() {
		let listItems = [] as any;
		if ( this.props.items && Array.isArray( this.props.items ) ) {
			listItems = this.props?.items.map( ( item: any, i: number ) => {
				const props = {
					[this.props.itemProp]: item,
				}
				return (
					<this.props.component {...props} />
				);
			} );
		}
		return (
			<div style={ { width: '100%' } }>
				{ ( Array.isArray( this.props.items ) && this.props.items.length > 0 )
				?	<Flex
						style={ { width: '100%' } }
						// @ts-ignore
						direction="column"
					>
						{ listItems }
					</Flex>
				: 	<div style={ { opacity: 0.5 } }>{ `No ${this.props.notFoundLabel ?? 'items'} were found.` }</div>
				}
			</div>
		);
	}
}
