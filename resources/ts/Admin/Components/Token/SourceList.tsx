import * as React from 'react';
import { Component } from 'react';
import SourceCard from './SourceCard';
import ResourceList from '../../Components/ResourceList';

import { 
	Flex,
} from '@wordpress/components';

interface SourceListProps {
	sources: Array<any>;
}

interface SourceListState {
	//
}

export default class SourceList extends Component<SourceListProps, SourceListState> {
	constructor( props: SourceListProps ) {
		super( props );
	}

	render() {
		return (
			<ResourceList
				items={ this.props.sources }
				component={ SourceCard }
				itemProp="source"
				notFoundLabel="sources"
			/>
		);
	}
}
