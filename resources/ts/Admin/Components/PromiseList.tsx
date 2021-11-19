import * as React from 'react';
import { Component } from 'react';
import { PromiseData } from '../../Interfaces';
import { PromiseCard } from './PromiseCard';

import { 
	Flex,
} from '@wordpress/components';

interface PromiseListProps {
	promises: Array<PromiseData>;
	onDetails: any;
	sources: any;
}

interface PromiseListState {
	//
}

export class PromiseList extends Component<PromiseListProps, PromiseListState> {

	constructor( props: PromiseListProps ) {
		super( props );
	}

	render() {
		let listItems = Object.keys( this.props.promises ).map( ( key: any ) => this.props.promises[ key ] ) as any;
		listItems = listItems.map( ( promiseItem: PromiseData, i: number ) => {
			return (
				<div style={ { width: '100%' } }>
					<PromiseCard promise={ promiseItem } sources={ this.props.sources } />
				</div>
			);
		}
		);
		return (
			// @ts-ignore
			<Flex style={ { width: '100%' } } direction="column">{ listItems }</Flex> 
		);
	}
}
