import * as React from 'react';
import { Component } from 'react';
import GroupCard from './GroupCard';
import ResourceList from '../../Components/ResourceList';

import { 
	Flex,
} from '@wordpress/components';

interface GroupListProps {
	groups: Array<any>;
}

interface GroupListState {
	//
}

export default class GroupList extends Component<GroupListProps, GroupListState> {
	constructor( props: GroupListProps ) {
		super( props );
	}

	render() {
		return (
			<ResourceList
				items={ this.props.groups }
				component={ GroupCard }
				itemProp="group"
				notFoundLabel="groups"
			/>
		);
	}
}
