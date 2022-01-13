import * as React from 'react';
import { Component } from 'react';
import PromiseCard from './PromiseCard';
import ResourceList from '../../Components/ResourceList';

import { 
	Flex,
} from '@wordpress/components';

interface PromiseListProps {
	promises: Array<any>;
}

interface PromiseListState {
	//
}

export default class PromiseList extends Component<PromiseListProps, PromiseListState> {
	constructor( props: PromiseListProps ) {
		super( props );
	}

	render() {
		return (
			<ResourceList
				items={ this.props.promises }
				component={ PromiseCard }
				itemProp="promise"
				notFoundLabel="promises"
			/>
		);
	}
}
