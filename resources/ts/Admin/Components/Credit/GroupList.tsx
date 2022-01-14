import * as React from 'react';
import GroupCard from './GroupCard';
import ResourceList from '../../Components/ResourceList';

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
