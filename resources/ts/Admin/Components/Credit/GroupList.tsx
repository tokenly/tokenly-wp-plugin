import * as React from 'react'
import GroupCard from './GroupCard'
import ResourceList from '../../Components/ResourceList'
import GroupCollectionInterface from '../../../Interfaces/Collections/Credit/GroupCollectionInterface'

interface GroupListProps {
	groups: GroupCollectionInterface
}

export default function GroupList( props: GroupListProps ) {
	return (
		<ResourceList
			items={ props.groups }
			component={ GroupCard }
			itemProp="group"
			notFoundLabel="groups"
		/>
	)
}
