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

export default function GroupList( props: GroupListProps ) {
	return (
		<ResourceList
			items={ props.groups }
			component={ GroupCard }
			itemProp="group"
			notFoundLabel="groups"
		/>
	);
}
