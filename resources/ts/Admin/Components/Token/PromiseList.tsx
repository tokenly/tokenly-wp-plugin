import * as React from 'react';
import { Component } from 'react';
import { PromiseData } from '../../../Interfaces';
import PromiseCard from './PromiseCard';

import { 
	Flex,
} from '@wordpress/components';

interface PromiseListProps {
	promises: Array<PromiseData>;
	onDetails: any;
	sources: any;
	loadingSources: boolean;
}

interface PromiseListState {
	//
}

export default class PromiseList extends Component<PromiseListProps, PromiseListState> {

	constructor( props: PromiseListProps ) {
		super( props );
	}

	render() {
		let listItems = [] as any;
		if ( this.props.promises && Array.isArray( this.props.promises ) ) {
			listItems = this.props?.promises.map( ( promiseItem: PromiseData, i: number ) => {
				return (
					<div style={ { width: '100%' } }>
						<PromiseCard loadingSources={ this.props.loadingSources } promise={ promiseItem } sources={ this.props.sources } />
					</div>
				);
			} );
		}
		return (
			// @ts-ignore
			<Flex style={ { width: '100%' } } direction="column">{ listItems }</Flex> 
		);
	}
}
